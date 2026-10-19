-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 19, 2026 at 12:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omniroute`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_providers`
--

CREATE TABLE `ai_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'openai',
  `description` text COLLATE utf8mb4_unicode_ci,
  `models_catalog` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_providers`
--

INSERT INTO `ai_providers` (`id`, `slug`, `name`, `base_url`, `format`, `description`, `models_catalog`, `is_active`, `created_at`, `updated_at`) VALUES
(111, 'river-ai', 'River AI', 'https://api.river.ai/v1', 'openai', 'website : https://api.river.ai/v1\r\nemail : masudgaminghub@gmail.com', '[\"deepseek-ai/DeepSeek-V4.1-Flash\", \"nvidia/NVIDIA-Nemotron-3.5-Super-VL-120B-A12B-NVFP4\", \"zai-org/GLM-5.3-Flash\", \"deepseek-ai/DeepSeek-V4.1-Flash-1017\"]', 1, '2026-10-19 02:43:59', '2026-10-19 02:45:22'),
(112, 'openroute', 'OpenRoute', 'https://openrouter.ai/api/v1', 'openai', 'https://openrouter.ai/api/v1/', '[\"deepseek/deepseek-v4.1-flash-1017\", \"elorian/glimpse\", \"xingchen-agi/xing4.0-29b-a4b:free\", \"reflection/beam-1.0-501b-a23b\", \"moondream/moondream3-preview\", \"moondream/moondream3.1-9b-a2b\", \"meta/muse-spark-open\", \"nvidia/nemotron-3.5-super-vl\", \"nvidia/nemotron-3.5-super-vl:free\", \"unbiased/pareto-26.10\", \"~unbiased/pareto-latest\", \"unbiased/pareto-26.9\", \"liquid/lfm-2.5-24b-a2b\", \"google/gemini-4-argon\", \"google/gemini-4-argon:batch\", \"scaledown/summarize\", \"scaledown/extract\", \"meta/muse-wonder\", \"stepfun/step-5-preview\", \"anthropic/claude-haiku-5.5\", \"anthropic/claude-haiku-5.5:batch\", \"google/gemini-nano-banana-2.1\", \"mistralai/mistral-large-4-0\", \"inclusionai/ling-3.1-flash\", \"openai/gpt-6.1-sol-pro\", \"openai/gpt-6.1-sol-pro:batch\", \"openai/gpt-6.1-sol\", \"openai/gpt-6.1-sol:batch\", \"anthropic/claude-sonnet-5.5\", \"anthropic/claude-sonnet-5.5:batch\", \"typesafe/jev-router\", \"perceptron/perceptron-mk1.5\", \"fireworks/ember-1\", \"z-ai/glm-5.3-prime\", \"qwen/qwen3.8-max-prime\", \"aion-labs/aion-3.5-mini\", \"aion-labs/aion-3.5\", \"upstage/solar-mini4\", \"cohere/command-a-plus\", \"openai/gpt-6-luna-pro\", \"openai/gpt-6-luna-pro:batch\", \"openai/gpt-6-luna\", \"openai/gpt-6-luna:batch\", \"openai/gpt-6-sol-pro\", \"openai/gpt-6-sol-pro:batch\", \"openai/gpt-6-sol\", \"openai/gpt-6-sol:batch\", \"anthropic/claude-opus-5.5\", \"anthropic/claude-opus-5.5:batch\", \"nvidia/switchyard\", \"xiaomi/mimo-v2.6-pro-ultraspeed\", \"xiaomi/mimo-v2.6-flash\", \"xiaomi/mimo-v2.6-pro\", \"x-ai/grok-4.7\", \"qwen/qwen3.8-omni-flash\", \"prism-ml/ternary-bonsai-2-27b\", \"z-ai/glm-5.3-flashx\", \"~deepseek/deepseek-pro-latest\", \"~deepseek/deepseek-flash-latest\", \"inference-net/schematron-v2-turbo\", \"inference-net/schematron-v2-small\", \"~openai/gpt-astra-latest\", \"~openai/gpt-sol-latest\", \"~openai/gpt-terra-latest\", \"~openai/gpt-luna-latest\", \"sakana/fugu-ultra-v2\", \"sakana/fugu-max\", \"inclusionai/ling-3.0-flash-vl\", \"deepseek/deepseek-v4.1-flash\", \"deepseek/deepseek-v4.1-flash:batch\", \"inception/mercury-2.5\", \"nex-agi/nex-n2.5-mini\", \"nex-agi/nex-n2.5-pro\", \"openai/gpt-6-astra\", \"openai/gpt-6-astra:batch\", \"openai/gpt-6-astra-pro\", \"openai/gpt-6-astra-pro:batch\", \"qwen/qwen3.8-max-0902\", \"meta/muse-spark-1.3-contributor\", \"meta/muse-spark-1.3\", \"google/gemini-3.8-flash\", \"google/gemini-3.8-flash:batch\", \"anthropic/claude-fable-5.1\", \"anthropic/claude-fable-5.1:batch\", \"ibm-granite/granite-4.2-8b\", \"tencent/hy4-preview\", \"~z-ai/glm-flash-latest\", \"qwen/qwen3.8-flash\", \"z-ai/glm-5.3-flash\", \"z-ai/glm-5.3-flash:batch\", \"meta/muse-spark-1.2-contributor\", \"deepseek/deepseek-v4-flash-vision-exp\", \"tencent/hy-mt2-1.8b\", \"tencent/hy-mt2-30b-a3b\", \"~z-ai/glm-latest\", \"tencent/hy-mt2-7b\", \"z-ai/glm-5.3\", \"z-ai/glm-5.3:batch\", \"qwen/qwen3.8-27b\", \"dots-studio/dots-3-note-preview:free\", \"google/gemini-3.7-flash\", \"google/gemini-3.7-flash:batch\", \"bytedance-seed/seed-2-1-turbo\", \"qwen/qwen3.8-2.4t-a95b\", \"bytedance-seed/seed-2.0-code\", \"deepseek/deepseek-v4-pro-0813\", \"x-ai/grok-4.6\", \"liquid/lfm-2.5-2.6b:free\", \"nvidia/nemotron-3.5-lightning\", \"nvidia/nemotron-3.5-lightning:free\", \"sakana/sakana-namazu\", \"upstage/solar-pro4\", \"meta/muse-glimmer-30b\", \"meta/muse-spark-1.2\", \"~deepseek/deepseek-v4-flash-latest\", \"deepseek/deepseek-v4-flash-0731\", \"thinkingmachines/inkling-small\", \"thinkingmachines/inkling-small:free\", \"qwen/qwen3.7-flash\", \"anthropic/claude-opus-5\", \"anthropic/claude-opus-5:batch\", \"inclusionai/ling-3.0-flash\", \"poolside/laguna-s-2.1\", \"poolside/laguna-s-2.1:free\", \"google/gemini-3.6-flash\", \"google/gemini-3.6-flash:batch\", \"google/gemini-3.5-flash-lite\", \"google/gemini-3.5-flash-lite:batch\", \"meituan/longcat-2.0\", \"thinkingmachines/inkling\", \"thinkingmachines/inkling:free\", \"openrouter/auto-beta\", \"moonshotai/kimi-k3\", \"moonshotai/kimi-k3:batch\", \"meta/muse-spark-1.1\", \"openai/gpt-5.6-luna-pro\", \"openai/gpt-5.6-luna-pro:batch\", \"openai/gpt-5.6-luna\", \"openai/gpt-5.6-luna:batch\", \"openai/gpt-5.6-terra-pro\", \"openai/gpt-5.6-terra-pro:batch\", \"openai/gpt-5.6-terra\", \"openai/gpt-5.6-terra:batch\", \"openai/gpt-5.6-sol-pro\", \"openai/gpt-5.6-sol-pro:batch\", \"openai/gpt-5.6-sol\", \"openai/gpt-5.6-sol:batch\", \"x-ai/grok-4.5\", \"~x-ai/grok-latest\", \"aion-labs/aion-3.0-mini\", \"aion-labs/aion-3.0\", \"tencent/hy3\", \"poolside/laguna-xs-2.1\", \"poolside/laguna-xs-2.1:free\", \"anthropic/claude-sonnet-5\", \"anthropic/claude-sonnet-5:batch\", \"google/gemini-3.1-flash-lite-image\", \"sakana/fugu-ultra\", \"google/gemini-3.1-flash-image\", \"google/gemini-3-pro-image\", \"cohere/north-mini-code:free\", \"z-ai/glm-5.2\", \"openrouter/fusion\", \"moonshotai/kimi-k2.7-code\", \"~anthropic/claude-fable-latest\", \"anthropic/claude-fable-5\", \"anthropic/claude-fable-5:batch\", \"nvidia/nemotron-3.5-content-safety\", \"nvidia/nemotron-3.5-content-safety:free\", \"nvidia/nemotron-3-ultra-550b-a55b\", \"nvidia/nemotron-3-ultra-550b-a55b:free\", \"qwen/qwen3.7-plus\", \"qwen/qwen3.7-plus:batch\", \"minimax/minimax-m3\", \"stepfun/step-3.7-flash\", \"anthropic/claude-opus-4.8\", \"anthropic/claude-opus-4.8:batch\", \"qwen/qwen3.7-max\", \"x-ai/grok-build-0.1\", \"google/gemini-3.5-flash\", \"google/gemini-3.5-flash:batch\", \"perceptron/perceptron-mk1\", \"google/gemini-3.1-flash-lite\", \"google/gemini-3.1-flash-lite:batch\", \"openai/gpt-chat-latest\", \"x-ai/grok-4.3\", \"x-ai/grok-4.3:batch\", \"mistralai/mistral-medium-3-5\", \"mistralai/mistral-medium-3-5:batch\", \"nvidia/nemotron-3-nano-omni-30b-a3b-reasoning:free\", \"~anthropic/claude-haiku-latest\", \"~openai/gpt-mini-latest\", \"~google/gemini-pro-latest\", \"~moonshotai/kimi-latest\", \"~google/gemini-flash-latest\", \"~anthropic/claude-sonnet-latest\", \"qwen/qwen3.5-plus-20260420\", \"qwen/qwen3.6-flash\", \"qwen/qwen3.6-35b-a3b\", \"qwen/qwen3.6-27b\", \"openai/gpt-5.5-pro\", \"openai/gpt-5.5-pro:batch\", \"openai/gpt-5.5\", \"openai/gpt-5.5:batch\", \"deepseek/deepseek-v4-pro\", \"deepseek/deepseek-v4-flash\", \"tencent/hy3-preview\", \"xiaomi/mimo-v2.5-pro\", \"xiaomi/mimo-v2.5\", \"openai/gpt-5.4-image-2\", \"~anthropic/claude-opus-latest\", \"openrouter/pareto-code\", \"moonshotai/kimi-k2.6\", \"anthropic/claude-opus-4.7\", \"anthropic/claude-opus-4.7:batch\", \"z-ai/glm-5.1\", \"google/gemma-4-26b-a4b-it\", \"google/gemma-4-26b-a4b-it:free\", \"google/gemma-4-31b-it\", \"google/gemma-4-31b-it:free\", \"qwen/qwen3.6-plus\", \"z-ai/glm-5v-turbo\", \"arcee-ai/trinity-large-thinking\", \"x-ai/grok-4.20-multi-agent\", \"x-ai/grok-4.20\", \"google/lyria-3-pro-preview\", \"google/lyria-3-clip-preview\", \"rekaai/reka-edge\", \"minimax/minimax-m2.7\", \"openai/gpt-5.4-nano\", \"openai/gpt-5.4-nano:batch\", \"openai/gpt-5.4-mini\", \"openai/gpt-5.4-mini:batch\", \"mistralai/mistral-small-2603\", \"mistralai/mistral-small-2603:batch\", \"z-ai/glm-5-turbo\", \"nvidia/nemotron-3-super-120b-a12b\", \"nvidia/nemotron-3-super-120b-a12b:free\", \"bytedance-seed/seed-2.0-lite\", \"qwen/qwen3.5-9b\", \"openai/gpt-5.4-pro\", \"openai/gpt-5.4-pro:batch\", \"openai/gpt-5.4\", \"openai/gpt-5.4:batch\", \"inception/mercury-2\", \"google/gemini-3.1-flash-lite-preview\", \"bytedance-seed/seed-2.0-mini\", \"google/gemini-3.1-flash-image-preview\", \"qwen/qwen3.5-35b-a3b\", \"qwen/qwen3.5-27b\", \"qwen/qwen3.5-122b-a10b\", \"qwen/qwen3.5-flash-02-23\", \"google/gemini-3.1-pro-preview-customtools\", \"openai/gpt-5.3-codex\", \"aion-labs/aion-2.0\", \"google/gemini-3.1-pro-preview\", \"google/gemini-3.1-pro-preview:batch\", \"anthropic/claude-sonnet-4.6\", \"anthropic/claude-sonnet-4.6:batch\", \"qwen/qwen3.5-plus-02-15\", \"qwen/qwen3.5-397b-a17b\", \"minimax/minimax-m2.5\", \"z-ai/glm-5\", \"anthropic/claude-opus-4.6\", \"anthropic/claude-opus-4.6:batch\", \"qwen/qwen3-coder-next\", \"openrouter/free\", \"stepfun/step-3.5-flash\", \"moonshotai/kimi-k2.5\", \"upstage/solar-pro-3\", \"minimax/minimax-m2-her\", \"writer/palmyra-x5\", \"openai/gpt-audio\", \"openai/gpt-audio-mini\", \"z-ai/glm-4.7-flash\", \"openai/gpt-5.2-codex\", \"bytedance-seed/seed-1.6-flash\", \"bytedance-seed/seed-1.6\", \"minimax/minimax-m2.1\", \"z-ai/glm-4.7\", \"google/gemini-3-flash-preview\", \"google/gemini-3-flash-preview:batch\", \"nvidia/nemotron-3-nano-30b-a3b\", \"openai/gpt-5.2-chat\", \"openai/gpt-5.2-pro\", \"openai/gpt-5.2-pro:batch\", \"openai/gpt-5.2\", \"openai/gpt-5.2:batch\", \"mistralai/devstral-2512\", \"relace/relace-search\", \"z-ai/glm-4.6v\", \"openrouter/bodybuilder\", \"openai/gpt-5.1-codex-max\", \"amazon/nova-2-lite-v1\", \"mistralai/ministral-14b-2512\", \"mistralai/ministral-8b-2512\", \"mistralai/ministral-8b-2512:batch\", \"mistralai/ministral-3b-2512\", \"mistralai/mistral-large-2512\", \"mistralai/mistral-large-2512:batch\", \"deepseek/deepseek-v3.2\", \"anthropic/claude-opus-4.5\", \"anthropic/claude-opus-4.5:batch\", \"google/gemini-3-pro-image-preview\", \"openai/gpt-5.1\", \"openai/gpt-5.1:batch\", \"openai/gpt-5.1-codex\", \"openai/gpt-5.1-codex-mini\", \"moonshotai/kimi-k2-thinking\", \"amazon/nova-premier-v1\", \"perplexity/sonar-pro-search\", \"mistralai/voxtral-small-24b-2507\", \"openai/gpt-oss-safeguard-20b\", \"minimax/minimax-m2\", \"ibm-granite/granite-4.0-h-micro\", \"openai/gpt-5-image-mini\", \"anthropic/claude-haiku-4.5\", \"anthropic/claude-haiku-4.5:batch\", \"qwen/qwen3-vl-8b-instruct\", \"openai/gpt-5-image\", \"google/gemini-2.5-flash-image\", \"qwen/qwen3-vl-30b-a3b-thinking\", \"qwen/qwen3-vl-30b-a3b-instruct\", \"openai/gpt-5-pro\", \"openai/gpt-5-pro:batch\", \"z-ai/glm-4.6\", \"anthropic/claude-sonnet-4.5\", \"anthropic/claude-sonnet-4.5:batch\", \"deepseek/deepseek-v3.2-exp\", \"thedrummer/cydonia-24b-v4.1\", \"relace/relace-apply-3\", \"qwen/qwen3-vl-235b-a22b-instruct\", \"deepseek/deepseek-v3.1-terminus\", \"qwen/qwen3-coder-flash\", \"qwen/qwen3-next-80b-a3b-thinking\", \"qwen/qwen3-next-80b-a3b-instruct\", \"moonshotai/kimi-k2-0905\", \"nousresearch/hermes-4-405b\", \"deepseek/deepseek-chat-v3.1\", \"mistralai/mistral-medium-3.1\", \"mistralai/mistral-medium-3.1:batch\", \"z-ai/glm-4.5v\", \"openai/gpt-5\", \"openai/gpt-5:batch\", \"openai/gpt-5-mini\", \"openai/gpt-5-mini:batch\", \"openai/gpt-5-nano\", \"openai/gpt-5-nano:batch\", \"openai/gpt-oss-120b\", \"openai/gpt-oss-120b:batch\", \"openai/gpt-oss-20b\", \"openai/gpt-oss-20b:batch\", \"anthropic/claude-opus-4.1\", \"anthropic/claude-opus-4.1:batch\", \"mistralai/codestral-2508\", \"mistralai/codestral-2508:batch\", \"qwen/qwen3-coder-30b-a3b-instruct\", \"qwen/qwen3-30b-a3b-instruct-2507\", \"z-ai/glm-4.5\", \"z-ai/glm-4.5-air\", \"qwen/qwen3-235b-a22b-thinking-2507\", \"qwen/qwen3-coder\", \"bytedance/ui-tars-1.5-7b\", \"google/gemini-2.5-flash-lite\", \"google/gemini-2.5-flash-lite:batch\", \"qwen/qwen3-235b-a22b-2507\", \"moonshotai/kimi-k2\", \"cognitivecomputations/dolphin-mistral-24b-venice-edition\", \"tencent/hunyuan-a13b-instruct\", \"morph/morph-v3-large\", \"morph/morph-v3-fast\", \"mistralai/mistral-small-3.2-24b-instruct\", \"minimax/minimax-m1\", \"google/gemini-2.5-flash\", \"google/gemini-2.5-flash:batch\", \"google/gemini-2.5-pro\", \"google/gemini-2.5-pro:batch\", \"openai/o3-pro\", \"google/gemini-2.5-pro-preview\", \"deepseek/deepseek-r1-0528\", \"mistralai/mistral-medium-3\", \"meta-llama/llama-guard-4-12b\", \"qwen/qwen3-30b-a3b\", \"qwen/qwen3-14b\", \"qwen/qwen3-32b\", \"openai/o4-mini-high\", \"openai/o3\", \"openai/o3:batch\", \"openai/o4-mini\", \"openai/o4-mini:batch\", \"openai/gpt-4.1\", \"openai/gpt-4.1:batch\", \"openai/gpt-4.1-mini\", \"openai/gpt-4.1-mini:batch\", \"openai/gpt-4.1-nano\", \"openai/gpt-4.1-nano:batch\", \"meta-llama/llama-4-maverick\", \"meta-llama/llama-4-scout\", \"deepseek/deepseek-chat-v3-0324\", \"openai/o1-pro\", \"mistralai/mistral-small-3.1-24b-instruct\", \"google/gemma-3-4b-it\", \"google/gemma-3-12b-it\", \"cohere/command-a\", \"rekaai/reka-flash-3\", \"google/gemma-3-27b-it\", \"thedrummer/skyfall-36b-v2\", \"perplexity/sonar-reasoning-pro\", \"perplexity/sonar-pro\", \"perplexity/sonar-deep-research\", \"mistralai/mistral-saba\", \"openai/o3-mini-high\", \"aion-labs/aion-rp-llama-3.1-8b\", \"qwen/qwen2.5-vl-72b-instruct\", \"qwen/qwen-plus\", \"openai/o3-mini\", \"openai/o3-mini:batch\", \"mistralai/mistral-small-24b-instruct-2501\", \"perplexity/sonar\", \"deepseek/deepseek-r1\", \"minimax/minimax-01\", \"microsoft/phi-4\", \"deepseek/deepseek-chat\", \"sao10k/l3.3-euryale-70b\", \"openai/o1\", \"cohere/command-r7b-12-2024\", \"meta-llama/llama-3.3-70b-instruct\", \"amazon/nova-lite-v1\", \"amazon/nova-micro-v1\", \"amazon/nova-pro-v1\", \"openai/gpt-4o-2024-11-20\", \"mistralai/mistral-large-2407\", \"qwen/qwen-2.5-coder-32b-instruct\", \"thedrummer/unslopnemo-12b\", \"anthracite-org/magnum-v4-72b\", \"qwen/qwen-2.5-7b-instruct\", \"meta-llama/llama-3.2-1b-instruct\", \"meta-llama/llama-3.2-3b-instruct\", \"qwen/qwen-2.5-72b-instruct\", \"cohere/command-r-08-2024\", \"cohere/command-r-plus-08-2024\", \"sao10k/l3.1-euryale-70b\", \"nousresearch/hermes-3-llama-3.1-70b\", \"nousresearch/hermes-3-llama-3.1-405b\", \"sao10k/l3-lunaris-8b\", \"openai/gpt-4o-2024-08-06\", \"meta-llama/llama-3.1-70b-instruct\", \"meta-llama/llama-3.1-8b-instruct\", \"mistralai/mistral-nemo\", \"openai/gpt-4o-mini\", \"openai/gpt-4o-mini-2024-07-18\", \"openai/gpt-4o-mini:batch\", \"google/gemma-2-27b-it\", \"openai/gpt-4o\", \"openai/gpt-4o-2024-05-13\", \"openai/gpt-4o:batch\", \"mistralai/mixtral-8x22b-instruct\", \"microsoft/wizardlm-2-8x22b\", \"openai/gpt-4-turbo\", \"openai/gpt-4-turbo:batch\", \"mistralai/mistral-large\", \"openai/gpt-3.5-turbo-0613\", \"openrouter/auto\", \"openai/gpt-3.5-turbo-instruct\", \"openai/gpt-3.5-turbo-16k\", \"mancer/weaver\", \"undi95/remm-slerp-l2-13b\", \"gryphe/mythomax-l2-13b\", \"openai/gpt-3.5-turbo\", \"openai/gpt-3.5-turbo:batch\", \"openai/gpt-4\"]', 1, '2026-10-19 03:27:03', '2026-10-19 03:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `alert_settings`
--

CREATE TABLE `alert_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `webhook_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'discord',
  `webhook_url` text COLLATE utf8mb4_unicode_ci,
  `telegram_bot_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_chat_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alert_circuit_breaker` tinyint(1) NOT NULL DEFAULT '1',
  `alert_account_cooldown` tinyint(1) NOT NULL DEFAULT '1',
  `alert_key_limit_exceeded` tinyint(1) NOT NULL DEFAULT '1',
  `last_alert_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alert_settings`
--

INSERT INTO `alert_settings` (`id`, `is_enabled`, `webhook_type`, `webhook_url`, `telegram_bot_token`, `telegram_chat_id`, `alert_circuit_breaker`, `alert_account_cooldown`, `alert_key_limit_exceeded`, `last_alert_sent_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'discord', 'https://discord.com/api/webhooks/999/token123', NULL, NULL, 1, 1, 1, '2026-10-19 05:56:36', '2026-10-19 05:46:40', '2026-10-19 05:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_keys`
--

CREATE TABLE `gateway_keys` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_token_limit` bigint DEFAULT NULL,
  `rpm_limit` int UNSIGNED DEFAULT NULL,
  `tpm_limit` bigint UNSIGNED DEFAULT NULL,
  `tokens_used_today` bigint NOT NULL DEFAULT '0',
  `usage_reset_date` date DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateway_keys`
--

INSERT INTO `gateway_keys` (`id`, `name`, `key`, `daily_token_limit`, `rpm_limit`, `tpm_limit`, `tokens_used_today`, `usage_reset_date`, `last_used_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Master Key', 'sk-omni-master-key-1234567890abcdef', NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-10-14 23:56:31', '2026-10-14 23:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_logs`
--

CREATE TABLE `gateway_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `gateway_key_id` bigint UNSIGNED DEFAULT NULL,
  `requested_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routed_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routed_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prompt_tokens` int NOT NULL DEFAULT '0',
  `completion_tokens` int NOT NULL DEFAULT '0',
  `total_tokens` int NOT NULL DEFAULT '0',
  `saved_tokens` int NOT NULL DEFAULT '0',
  `cost_usd` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `cost_saved_usd` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `latency_ms` int NOT NULL DEFAULT '0',
  `status_code` int NOT NULL DEFAULT '200',
  `is_cached` tinyint(1) NOT NULL DEFAULT '0',
  `redacted_pii_count` int UNSIGNED NOT NULL DEFAULT '0',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_15_000001_create_omniroute_tables', 1),
(5, '2026_10_18_112538_add_description_to_ai_providers_table', 2),
(6, '2026_10_19_162000_add_is_cached_to_gateway_logs_table', 3),
(7, '2026_10_19_164500_create_model_pricings_and_add_cost_to_logs', 4),
(8, '2026_10_19_172000_add_rpm_tpm_to_gateway_keys_table', 5),
(9, '2026_10_19_174000_add_redacted_pii_count_to_gateway_logs_table', 6),
(10, '2026_10_19_180000_create_alert_settings_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_pricings`
--

CREATE TABLE `model_pricings` (
  `id` bigint UNSIGNED NOT NULL,
  `model_pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_cost_per_million` decimal(10,4) NOT NULL DEFAULT '0.1500',
  `output_cost_per_million` decimal(10,4) NOT NULL DEFAULT '0.6000',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_pricings`
--

INSERT INTO `model_pricings` (`id`, `model_pattern`, `display_name`, `input_cost_per_million`, `output_cost_per_million`, `currency`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'deepseek*', 'DeepSeek V3 / V4 / Flash', '0.1400', '0.2800', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(2, 'gpt-4o-mini*', 'OpenAI GPT-4o Mini', '0.1500', '0.6000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(3, 'gpt-4o*', 'OpenAI GPT-4o (Omni)', '2.5000', '10.0000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(4, 'claude-3-5-sonnet*', 'Anthropic Claude 3.5 Sonnet', '3.0000', '15.0000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(5, 'claude-3-5-haiku*', 'Anthropic Claude 3.5 Haiku', '0.8000', '4.0000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(6, 'gemini-1.5-flash*', 'Google Gemini 1.5 Flash', '0.0750', '0.3000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(7, 'gemini-1.5-pro*', 'Google Gemini 1.5 Pro', '1.2500', '5.0000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(8, 'qwen*', 'Alibaba Qwen 2.5', '0.2000', '0.6000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(9, 'glm*', 'Zhipu GLM-4 / Flash', '0.1000', '0.2000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58'),
(10, '*', 'Default Fallback Pricing', '0.2000', '0.6000', 'USD', 1, '2026-10-19 04:42:58', '2026-10-19 04:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider_accounts`
--

CREATE TABLE `provider_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `ai_provider_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '1',
  `daily_token_limit` bigint DEFAULT NULL,
  `tokens_used_today` bigint NOT NULL DEFAULT '0',
  `usage_reset_date` date DEFAULT NULL,
  `cooldown_until` timestamp NULL DEFAULT NULL,
  `fail_count` int NOT NULL DEFAULT '0',
  `last_error` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_accounts`
--

INSERT INTO `provider_accounts` (`id`, `ai_provider_id`, `label`, `api_key`, `priority`, `daily_token_limit`, `tokens_used_today`, `usage_reset_date`, `cooldown_until`, `fail_count`, `last_error`, `is_active`, `created_at`, `updated_at`) VALUES
(117, 111, 'test', 'eyJpdiI6InVnU21TNVdEejFta01MLzFjd2JMN2c9PSIsInZhbHVlIjoia0tsL1F2YlBBa0wzYzhkcXhkd0NlSTFQNzhPQ0RwQ1lUcWlkVGhDVEZmaVNtYTFBbWdzN0RSZWo4c1prSnBkaCIsIm1hYyI6ImJmNjlmNDUzYTM3NzQ3YjQ1ZWY5NWVmOGYyYzZlZDkzNTU3NDY4ZGJkYTRhODk2ZjEwODk1MjYwMTM4NzZiNGEiLCJ0YWciOiIifQ==', 1, NULL, 1168, '2026-10-19', NULL, 0, NULL, 1, '2026-10-19 02:45:21', '2026-10-19 05:08:17'),
(118, 112, 'open-route', 'eyJpdiI6ImtUVFF0TnJ1SDE5L1RDdnpnaVFmOGc9PSIsInZhbHVlIjoidHJacTJQUkNzTEJ4V2FVdEZ0T1g0Si95STFoOFBtV29qYjJMNTk0cFNXcDZRanQ0ZHFqWGNEU244RG1TZTJVaU5weWlVcUpNVVFrczR4MGhSSEcrT05IQVN0MG1nK3EySVlBRndvRERKOHc9IiwibWFjIjoiNjViNThmZWY3OWJmNzhhMGI0MTZiMzAxYWE3ODY2NzBkYWE2YjAxYTFiN2QyM2MxOTgwM2ZjZjIxYmUyYmQ4NiIsInRhZyI6IiJ9', 1, NULL, 0, '2026-10-19', '2026-10-19 05:53:55', 2, 'HTTP 402 Auth/Quota: {\"error\":{\"message\":\"This request requires more credits, or fewer max_tokens. You requested up to 32768 tokens, but can only afford 5298. To increase, visit https://openrouter.ai/settings/credits and upgrade to a paid account\",\"code\":402,\"metadata\":{\"limit_source\":\"openrouter_credits\",\"remedy_hint\":\"Add credits at https://openrouter.ai/settings/credits, or lower max_tokens / prompt size to fit your remaining balance.\",\"provider_name\":null}},\"user_id\":\"user_35uWaKiHZZxg5bJORQbU55PTHl7\"}', 1, '2026-10-19 03:27:17', '2026-10-19 04:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `routing_combos`
--

CREATE TABLE `routing_combos` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strategy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'priority',
  `models` json NOT NULL,
  `compression_modes` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routing_combos`
--

INSERT INTO `routing_combos` (`id`, `name`, `description`, `strategy`, `models`, `compression_modes`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'coding', NULL, 'priority', '[\"openroute/aion-labs/aion-3.5-mini\", \"river-ai/deepseek-ai/DeepSeek-V4.1-Flash\"]', '[\"dedup\", \"lite\"]', 1, '2026-10-19 03:45:35', '2026-10-19 03:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cxZY9KBlsnrHJoxCWE27e99IjO79Nj4LYGRuh3j0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ2VFNFdDhrQjdRaFpVVlVCNHFlbjNITGprcWgwMExJOUZJcDFFS0xoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9vbW5pcm91dGUtbGFyYXZlbC50ZXN0XC9kYXNoYm9hcmRcL3Byb3ZpZGVyc1wvcml2ZXItYWkiLCJyb3V0ZSI6ImRhc2hib2FyZC5wcm92aWRlcnMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1792413873),
('D20XxAh8yM24YcAMoOqEjtIBdqR6oAAnEgpyIwxn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJGbEZMaE9vb1hPSE1USFV2VllTa1dyU3M5dXpSc2lPc1V6RnhidzQwIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL29tbmlyb3V0ZS1sYXJhdmVsLnRlc3RcL2Rhc2hib2FyZFwvcHJvdmlkZXJzXC9yaXZlci1haSIsInJvdXRlIjoiZGFzaGJvYXJkLnByb3ZpZGVycy5zaG93In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZjA2N2M1OTBiNjJhYWU1YjU3ZDE2YzE3OTRhYjU1ZTMyZGNjYWNlYmZmOGY5YzA0NDE5ZTkxZThmNTA5YmM5NiJ9', 1792413111);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'OmniRoute Admin', 'admin@omniroute.local', '2026-10-19 05:06:34', '$2y$12$y6TFlKn.ZAYMJUxMXJEBEeY5x9SM9p3UpHAUci9fgItLcpVW7gahW', 'Y9MCHleOK1YMVQkJ8GP0VjdalDKUtjy73wqg2iiHft8ASHUeiMDc9Gm63P5J', '2026-10-14 23:56:31', '2026-10-19 05:06:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_providers`
--
ALTER TABLE `ai_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ai_providers_slug_unique` (`slug`);

--
-- Indexes for table `alert_settings`
--
ALTER TABLE `alert_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `gateway_keys`
--
ALTER TABLE `gateway_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gateway_keys_key_unique` (`key`);

--
-- Indexes for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gateway_logs_gateway_key_id_foreign` (`gateway_key_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_pricings`
--
ALTER TABLE `model_pricings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_pricings_model_pattern_unique` (`model_pattern`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_accounts_ai_provider_id_foreign` (`ai_provider_id`);

--
-- Indexes for table `routing_combos`
--
ALTER TABLE `routing_combos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `routing_combos_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_providers`
--
ALTER TABLE `ai_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `alert_settings`
--
ALTER TABLE `alert_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_keys`
--
ALTER TABLE `gateway_keys`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `model_pricings`
--
ALTER TABLE `model_pricings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `routing_combos`
--
ALTER TABLE `routing_combos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  ADD CONSTRAINT `gateway_logs_gateway_key_id_foreign` FOREIGN KEY (`gateway_key_id`) REFERENCES `gateway_keys` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  ADD CONSTRAINT `provider_accounts_ai_provider_id_foreign` FOREIGN KEY (`ai_provider_id`) REFERENCES `ai_providers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
