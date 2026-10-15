<?php

namespace App\Services\Gateway;

class FormatTranslator
{
    /**
     * Convert OpenAI Chat Completions payload into Anthropic /v1/messages payload.
     *
     * @param string $model
     * @param array<string, mixed> $openaiPayload
     * @return array<string, mixed>
     */
    public function toAnthropicPayload(string $model, array $openaiPayload): array
    {
        $systemParts = [];
        $anthropicMessages = [];

        foreach ($openaiPayload['messages'] ?? [] as $msg) {
            $role = $msg['role'] ?? 'user';
            $content = $msg['content'] ?? '';

            if ($role === 'system') {
                if (is_string($content)) {
                    $systemParts[] = trim($content);
                } elseif (is_array($content)) {
                    $textParts = [];
                    foreach ($content as $item) {
                        if (is_array($item) && isset($item['text'])) {
                            $textParts[] = $item['text'];
                        }
                    }
                    $systemParts[] = implode("\n", $textParts);
                }
                continue;
            }

            // Map role for Anthropic ('user' or 'assistant')
            $mappedRole = ($role === 'assistant') ? 'assistant' : 'user';

            // Anthropic requires strictly alternating user/assistant messages.
            // If consecutive messages share the same role, combine their contents.
            $lastIndex = count($anthropicMessages) - 1;
            if ($lastIndex >= 0 && $anthropicMessages[$lastIndex]['role'] === $mappedRole) {
                $prev = $anthropicMessages[$lastIndex]['content'];
                if (is_string($prev) && is_string($content)) {
                    $anthropicMessages[$lastIndex]['content'] = $prev . "\n\n" . $content;
                } elseif (is_array($prev) && is_array($content)) {
                    $anthropicMessages[$lastIndex]['content'] = array_merge($prev, $content);
                } else {
                    $prevStr = is_string($prev) ? $prev : json_encode($prev);
                    $currStr = is_string($content) ? $content : json_encode($content);
                    $anthropicMessages[$lastIndex]['content'] = $prevStr . "\n\n" . $currStr;
                }
            } else {
                $anthropicMessages[] = [
                    'role' => $mappedRole,
                    'content' => $content,
                ];
            }
        }

        // Anthropic requires the first message in the array to be from the 'user'
        if (!empty($anthropicMessages) && $anthropicMessages[0]['role'] !== 'user') {
            array_unshift($anthropicMessages, [
                'role' => 'user',
                'content' => 'Hello',
            ]);
        }

        $payload = [
            'model' => $model,
            'messages' => $anthropicMessages,
            'max_tokens' => (int) ($openaiPayload['max_tokens'] ?? $openaiPayload['max_completion_tokens'] ?? 4096),
        ];

        if (!empty($systemParts)) {
            $payload['system'] = implode("\n\n", array_filter($systemParts));
        }

        if (isset($openaiPayload['temperature'])) {
            $payload['temperature'] = (float) $openaiPayload['temperature'];
        }

        if (isset($openaiPayload['top_p'])) {
            $payload['top_p'] = (float) $openaiPayload['top_p'];
        }

        if (isset($openaiPayload['stream'])) {
            $payload['stream'] = (bool) $openaiPayload['stream'];
        }

        if (isset($openaiPayload['stop'])) {
            $payload['stop_sequences'] = is_array($openaiPayload['stop'])
                ? $openaiPayload['stop']
                : [$openaiPayload['stop']];
        }

        return $payload;
    }

    /**
     * Convert Anthropic JSON response into standard OpenAI chat.completion format.
     *
     * @param array<string, mixed> $raw
     * @param string $model
     * @return array<string, mixed>
     */
    public function fromAnthropicResponse(array $raw, string $model): array
    {
        $content = '';
        if (isset($raw['content'])) {
            if (is_array($raw['content'])) {
                foreach ($raw['content'] as $block) {
                    if (is_array($block) && ($block['type'] ?? '') === 'text') {
                        $content .= $block['text'] ?? '';
                    } elseif (is_string($block)) {
                        $content .= $block;
                    }
                }
            } elseif (is_string($raw['content'])) {
                $content = $raw['content'];
            }
        }

        $stopReason = $raw['stop_reason'] ?? 'end_turn';
        $finishReason = match ($stopReason) {
            'end_turn' => 'stop',
            'max_tokens' => 'length',
            'stop_sequence' => 'stop',
            default => 'stop',
        };

        $promptTokens = (int) ($raw['usage']['input_tokens'] ?? 0);
        $completionTokens = (int) ($raw['usage']['output_tokens'] ?? 0);

        return [
            'id' => $raw['id'] ?? ('chatcmpl-' . bin2hex(random_bytes(12))),
            'object' => 'chat.completion',
            'created' => time(),
            'model' => $model,
            'choices' => [
                [
                    'index' => 0,
                    'message' => [
                        'role' => 'assistant',
                        'content' => $content,
                    ],
                    'finish_reason' => $finishReason,
                ],
            ],
            'usage' => [
                'prompt_tokens' => $promptTokens,
                'completion_tokens' => $completionTokens,
                'total_tokens' => $promptTokens + $completionTokens,
            ],
        ];
    }

    /**
     * Translate Anthropic streaming SSE lines into OpenAI SSE format.
     *
     * @param string $rawSseLine
     * @param string $model
     * @return string|null
     */
    public function translateAnthropicStreamChunk(string $rawSseLine, string $model): ?string
    {
        $line = trim($rawSseLine);
        if ($line === '' || $line === 'event: ping') {
            return null;
        }

        if (str_starts_with($line, 'event: message_stop') || $line === 'data: [DONE]') {
            return "data: [DONE]\n\n";
        }

        $jsonStr = $line;
        if (str_starts_with($line, 'data: ')) {
            $jsonStr = trim(substr($line, 6));
        }

        if ($jsonStr === '[DONE]') {
            return "data: [DONE]\n\n";
        }

        $data = json_decode($jsonStr, true);
        if (!is_array($data)) {
            return null;
        }

        $type = $data['type'] ?? '';

        if ($type === 'message_stop') {
            return "data: [DONE]\n\n";
        }

        if ($type === 'content_block_delta') {
            $text = $data['delta']['text'] ?? '';
            $chunk = [
                'id' => 'chatcmpl-chunk-' . substr(md5($model . microtime()), 0, 12),
                'object' => 'chat.completion.chunk',
                'created' => time(),
                'model' => $model,
                'choices' => [
                    [
                        'index' => 0,
                        'delta' => [
                            'content' => $text,
                        ],
                    ],
                ],
            ];

            return 'data: ' . json_encode($chunk, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";
        }

        return null;
    }
}
