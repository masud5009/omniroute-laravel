-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2026 at 12:11 PM
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-alert_debounce:account_cooldown:0a42ac54c379864d37f6c0e3fa656c7f', 'b:1;', 1792496959),
('laravel-cache-omni_cache_misses', 'i:1;', 2107856899),
('laravel-cache-omni_model_pricings', 'a:10:{i:0;a:9:{s:2:\"id\";i:1;s:13:\"model_pattern\";s:9:\"deepseek*\";s:12:\"display_name\";s:24:\"DeepSeek V3 / V4 / Flash\";s:22:\"input_cost_per_million\";d:0.14;s:23:\"output_cost_per_million\";d:0.28;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:1;a:9:{s:2:\"id\";i:2;s:13:\"model_pattern\";s:12:\"gpt-4o-mini*\";s:12:\"display_name\";s:18:\"OpenAI GPT-4o Mini\";s:22:\"input_cost_per_million\";d:0.15;s:23:\"output_cost_per_million\";d:0.6;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:2;a:9:{s:2:\"id\";i:3;s:13:\"model_pattern\";s:7:\"gpt-4o*\";s:12:\"display_name\";s:20:\"OpenAI GPT-4o (Omni)\";s:22:\"input_cost_per_million\";d:2.5;s:23:\"output_cost_per_million\";d:10;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:3;a:9:{s:2:\"id\";i:4;s:13:\"model_pattern\";s:18:\"claude-3-5-sonnet*\";s:12:\"display_name\";s:27:\"Anthropic Claude 3.5 Sonnet\";s:22:\"input_cost_per_million\";d:3;s:23:\"output_cost_per_million\";d:15;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:4;a:9:{s:2:\"id\";i:5;s:13:\"model_pattern\";s:17:\"claude-3-5-haiku*\";s:12:\"display_name\";s:26:\"Anthropic Claude 3.5 Haiku\";s:22:\"input_cost_per_million\";d:0.8;s:23:\"output_cost_per_million\";d:4;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:5;a:9:{s:2:\"id\";i:6;s:13:\"model_pattern\";s:17:\"gemini-1.5-flash*\";s:12:\"display_name\";s:23:\"Google Gemini 1.5 Flash\";s:22:\"input_cost_per_million\";d:0.075;s:23:\"output_cost_per_million\";d:0.3;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:6;a:9:{s:2:\"id\";i:7;s:13:\"model_pattern\";s:15:\"gemini-1.5-pro*\";s:12:\"display_name\";s:21:\"Google Gemini 1.5 Pro\";s:22:\"input_cost_per_million\";d:1.25;s:23:\"output_cost_per_million\";d:5;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:7;a:9:{s:2:\"id\";i:8;s:13:\"model_pattern\";s:5:\"qwen*\";s:12:\"display_name\";s:16:\"Alibaba Qwen 2.5\";s:22:\"input_cost_per_million\";d:0.2;s:23:\"output_cost_per_million\";d:0.6;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:8;a:9:{s:2:\"id\";i:9;s:13:\"model_pattern\";s:4:\"glm*\";s:12:\"display_name\";s:19:\"Zhipu GLM-4 / Flash\";s:22:\"input_cost_per_million\";d:0.1;s:23:\"output_cost_per_million\";d:0.2;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}i:9;a:9:{s:2:\"id\";i:10;s:13:\"model_pattern\";s:1:\"*\";s:12:\"display_name\";s:24:\"Default Fallback Pricing\";s:22:\"input_cost_per_million\";d:0.2;s:23:\"output_cost_per_million\";d:0.6;s:8:\"currency\";s:3:\"USD\";s:9:\"is_active\";b:1;s:10:\"created_at\";s:27:\"2026-10-19T10:42:58.000000Z\";s:10:\"updated_at\";s:27:\"2026-10-19T10:42:58.000000Z\";}}', 1792500501),
('laravel-cache-omni_resp_cache:6ff46eed1a640d2880dc777a94f63f989fa56e9703e0114a5b79dfe27b3fbfd1', 'a:2:{s:8:\"response\";a:6:{s:2:\"id\";s:22:\"chatcmpl-6ad7550430c3a\";s:6:\"object\";s:15:\"chat.completion\";s:7:\"created\";i:1792496900;s:5:\"model\";s:31:\"deepseek-ai/DeepSeek-V4.1-Flash\";s:7:\"choices\";a:1:{i:0;a:4:{s:5:\"index\";i:0;s:7:\"message\";a:2:{s:4:\"role\";s:9:\"assistant\";s:7:\"content\";s:27:\"Hi! How canYou doing today?\";}s:13:\"finish_reason\";s:4:\"stop\";s:12:\"matched_stop\";N;}}s:5:\"usage\";a:5:{s:13:\"prompt_tokens\";i:15;s:17:\"completion_tokens\";i:9;s:12:\"total_tokens\";i:24;s:21:\"prompt_tokens_details\";a:1:{s:13:\"cached_tokens\";i:0;}s:25:\"completion_tokens_details\";a:1:{s:16:\"reasoning_tokens\";i:0;}}}s:4:\"meta\";a:10:{s:8:\"provider\";s:8:\"river-ai\";s:5:\"model\";s:31:\"deepseek-ai/DeepSeek-V4.1-Flash\";s:7:\"account\";s:4:\"test\";s:12:\"saved_tokens\";i:0;s:8:\"cost_usd\";d:5.0E-6;s:14:\"cost_saved_usd\";d:0;s:10:\"latency_ms\";i:1003;s:6:\"cached\";b:1;s:18:\"redacted_pii_count\";i:0;s:9:\"cached_at\";s:25:\"2026-10-20T11:48:21+00:00\";}}', 1792583301),
('laravel-cache-roster:project:v3:f7681ddf0abb860ec69170a604018959', 'O:26:\"Laravel\\Roster\\ProjectScan\":8:{s:8:\"basePath\";s:33:\"D:\\laragon\\www\\omniroute-laravel\\\";s:3:\"php\";O:35:\"Laravel\\Roster\\Ecosystems\\Ecosystem\":2:{s:9:\"\0*\0byName\";a:115:{s:10:\"brick/math\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:10:\"brick/math\";s:10:\"\0*\0version\";s:5:\"1.0.0\";s:9:\"\0*\0source\";E:43:\"Laravel\\Roster\\Enums\\PackageSource:Composer\";s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:50:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\brick\\math\";}s:31:\"carbonphp/carbon-doctrine-types\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:31:\"carbonphp/carbon-doctrine-types\";s:10:\"\0*\0version\";s:5:\"3.2.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:71:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\carbonphp\\carbon-doctrine-types\";}s:23:\"dflydev/dot-access-data\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:23:\"dflydev/dot-access-data\";s:10:\"\0*\0version\";s:5:\"3.0.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\dflydev\\dot-access-data\";}s:18:\"doctrine/inflector\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:18:\"doctrine/inflector\";s:10:\"\0*\0version\";s:5:\"2.1.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:58:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\doctrine\\inflector\";}s:14:\"doctrine/lexer\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"doctrine/lexer\";s:10:\"\0*\0version\";s:5:\"3.0.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\doctrine\\lexer\";}s:29:\"dragonmantank/cron-expression\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:29:\"dragonmantank/cron-expression\";s:10:\"\0*\0version\";s:5:\"3.6.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:69:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\dragonmantank\\cron-expression\";}s:23:\"egulias/email-validator\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:23:\"egulias/email-validator\";s:10:\"\0*\0version\";s:5:\"4.0.4\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\egulias\\email-validator\";}s:18:\"fruitcake/php-cors\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:18:\"fruitcake/php-cors\";s:10:\"\0*\0version\";s:5:\"1.4.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:58:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\fruitcake\\php-cors\";}s:27:\"graham-campbell/result-type\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:27:\"graham-campbell/result-type\";s:10:\"\0*\0version\";s:5:\"1.2.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:67:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\graham-campbell\\result-type\";}s:17:\"guzzlehttp/guzzle\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"guzzlehttp/guzzle\";s:10:\"\0*\0version\";s:5:\"8.2.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\guzzlehttp\\guzzle\";}s:19:\"guzzlehttp/promises\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"guzzlehttp/promises\";s:10:\"\0*\0version\";s:5:\"3.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\guzzlehttp\\promises\";}s:15:\"guzzlehttp/psr7\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"guzzlehttp/psr7\";s:10:\"\0*\0version\";s:5:\"3.1.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\guzzlehttp\\psr7\";}s:23:\"guzzlehttp/uri-template\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:23:\"guzzlehttp/uri-template\";s:10:\"\0*\0version\";s:5:\"2.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\guzzlehttp\\uri-template\";}s:17:\"laravel/framework\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"13.36.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^13.17\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\framework\";}s:15:\"laravel/prompts\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:6:\"0.3.26\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\prompts\";}s:28:\"laravel/serializable-closure\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:28:\"laravel/serializable-closure\";s:10:\"\0*\0version\";s:5:\"2.1.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:68:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\serializable-closure\";}s:14:\"laravel/tinker\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"laravel/tinker\";s:10:\"\0*\0version\";s:5:\"3.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^3.0\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\tinker\";}s:17:\"league/commonmark\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"league/commonmark\";s:10:\"\0*\0version\";s:6:\"2.10.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\commonmark\";}s:13:\"league/config\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:13:\"league/config\";s:10:\"\0*\0version\";s:5:\"1.2.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:53:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\config\";}s:16:\"league/flysystem\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"league/flysystem\";s:10:\"\0*\0version\";s:6:\"3.36.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\flysystem\";}s:22:\"league/flysystem-local\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"league/flysystem-local\";s:10:\"\0*\0version\";s:6:\"3.35.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\flysystem-local\";}s:26:\"league/mime-type-detection\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:26:\"league/mime-type-detection\";s:10:\"\0*\0version\";s:6:\"1.17.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:66:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\mime-type-detection\";}s:10:\"league/uri\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:10:\"league/uri\";s:10:\"\0*\0version\";s:5:\"7.8.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:50:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\uri\";}s:21:\"league/uri-interfaces\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:21:\"league/uri-interfaces\";s:10:\"\0*\0version\";s:5:\"7.8.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:61:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\league\\uri-interfaces\";}s:15:\"monolog/monolog\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"monolog/monolog\";s:10:\"\0*\0version\";s:6:\"3.12.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\monolog\\monolog\";}s:13:\"nesbot/carbon\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:13:\"nesbot/carbon\";s:10:\"\0*\0version\";s:6:\"3.14.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:53:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nesbot\\carbon\";}s:12:\"nette/schema\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"nette/schema\";s:10:\"\0*\0version\";s:5:\"1.3.6\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:52:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nette\\schema\";}s:11:\"nette/utils\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"nette/utils\";s:10:\"\0*\0version\";s:5:\"4.1.5\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nette\\utils\";}s:16:\"nikic/php-parser\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"nikic/php-parser\";s:10:\"\0*\0version\";s:5:\"5.9.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nikic\\php-parser\";}s:19:\"nunomaduro/termwind\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"nunomaduro/termwind\";s:10:\"\0*\0version\";s:5:\"2.4.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nunomaduro\\termwind\";}s:19:\"phpoption/phpoption\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"phpoption/phpoption\";s:10:\"\0*\0version\";s:6:\"1.10.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpoption\\phpoption\";}s:9:\"psr/clock\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:9:\"psr/clock\";s:10:\"\0*\0version\";s:5:\"1.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:49:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\clock\";}s:13:\"psr/container\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:13:\"psr/container\";s:10:\"\0*\0version\";s:5:\"2.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:53:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\container\";}s:20:\"psr/event-dispatcher\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"psr/event-dispatcher\";s:10:\"\0*\0version\";s:5:\"1.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\event-dispatcher\";}s:15:\"psr/http-client\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"psr/http-client\";s:10:\"\0*\0version\";s:5:\"1.0.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\http-client\";}s:16:\"psr/http-factory\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"psr/http-factory\";s:10:\"\0*\0version\";s:5:\"1.1.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\http-factory\";}s:16:\"psr/http-message\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"psr/http-message\";s:10:\"\0*\0version\";s:3:\"2.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\http-message\";}s:7:\"psr/log\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:7:\"psr/log\";s:10:\"\0*\0version\";s:5:\"3.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:47:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\log\";}s:16:\"psr/simple-cache\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"psr/simple-cache\";s:10:\"\0*\0version\";s:5:\"3.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psr\\simple-cache\";}s:9:\"psy/psysh\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:9:\"psy/psysh\";s:10:\"\0*\0version\";s:7:\"0.12.24\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:49:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\psy\\psysh\";}s:17:\"ramsey/collection\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"ramsey/collection\";s:10:\"\0*\0version\";s:5:\"2.1.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\ramsey\\collection\";}s:11:\"ramsey/uuid\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"ramsey/uuid\";s:10:\"\0*\0version\";s:5:\"4.9.4\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\ramsey\\uuid\";}s:13:\"symfony/clock\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:13:\"symfony/clock\";s:10:\"\0*\0version\";s:5:\"7.4.8\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:53:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\clock\";}s:15:\"symfony/console\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"symfony/console\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\console\";}s:20:\"symfony/css-selector\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"symfony/css-selector\";s:10:\"\0*\0version\";s:6:\"7.4.18\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\css-selector\";}s:29:\"symfony/deprecation-contracts\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:29:\"symfony/deprecation-contracts\";s:10:\"\0*\0version\";s:5:\"3.7.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:69:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\deprecation-contracts\";}s:21:\"symfony/error-handler\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:21:\"symfony/error-handler\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:61:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\error-handler\";}s:24:\"symfony/event-dispatcher\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:24:\"symfony/event-dispatcher\";s:10:\"\0*\0version\";s:6:\"7.4.17\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:64:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\event-dispatcher\";}s:34:\"symfony/event-dispatcher-contracts\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:34:\"symfony/event-dispatcher-contracts\";s:10:\"\0*\0version\";s:5:\"3.7.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:74:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\event-dispatcher-contracts\";}s:14:\"symfony/finder\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"symfony/finder\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\finder\";}s:23:\"symfony/http-foundation\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:23:\"symfony/http-foundation\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\http-foundation\";}s:19:\"symfony/http-kernel\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"symfony/http-kernel\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\http-kernel\";}s:14:\"symfony/mailer\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"symfony/mailer\";s:10:\"\0*\0version\";s:6:\"7.4.19\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\mailer\";}s:12:\"symfony/mime\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"symfony/mime\";s:10:\"\0*\0version\";s:6:\"7.4.19\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:52:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\mime\";}s:22:\"symfony/polyfill-ctype\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-ctype\";s:10:\"\0*\0version\";s:6:\"1.37.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-ctype\";}s:30:\"symfony/polyfill-intl-grapheme\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:30:\"symfony/polyfill-intl-grapheme\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:70:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-intl-grapheme\";}s:25:\"symfony/polyfill-intl-idn\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"symfony/polyfill-intl-idn\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-intl-idn\";}s:32:\"symfony/polyfill-intl-normalizer\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:32:\"symfony/polyfill-intl-normalizer\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:72:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-intl-normalizer\";}s:25:\"symfony/polyfill-mbstring\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"symfony/polyfill-mbstring\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-mbstring\";}s:22:\"symfony/polyfill-php80\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php80\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php80\";}s:22:\"symfony/polyfill-php82\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php82\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php82\";}s:22:\"symfony/polyfill-php83\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php83\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php83\";}s:22:\"symfony/polyfill-php84\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php84\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php84\";}s:22:\"symfony/polyfill-php85\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php85\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php85\";}s:22:\"symfony/polyfill-php86\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"symfony/polyfill-php86\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-php86\";}s:21:\"symfony/polyfill-uuid\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:21:\"symfony/polyfill-uuid\";s:10:\"\0*\0version\";s:6:\"1.43.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:61:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\polyfill-uuid\";}s:15:\"symfony/process\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"symfony/process\";s:10:\"\0*\0version\";s:6:\"7.4.19\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\process\";}s:15:\"symfony/routing\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"symfony/routing\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\routing\";}s:25:\"symfony/service-contracts\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"symfony/service-contracts\";s:10:\"\0*\0version\";s:5:\"3.7.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\service-contracts\";}s:14:\"symfony/string\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"symfony/string\";s:10:\"\0*\0version\";s:6:\"7.4.19\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\string\";}s:19:\"symfony/translation\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"symfony/translation\";s:10:\"\0*\0version\";s:6:\"7.4.17\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\translation\";}s:29:\"symfony/translation-contracts\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:29:\"symfony/translation-contracts\";s:10:\"\0*\0version\";s:5:\"3.7.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:69:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\translation-contracts\";}s:11:\"symfony/uid\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"symfony/uid\";s:10:\"\0*\0version\";s:6:\"7.4.20\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\uid\";}s:18:\"symfony/var-dumper\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:18:\"symfony/var-dumper\";s:10:\"\0*\0version\";s:6:\"7.4.18\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:58:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\var-dumper\";}s:33:\"tijsverkoyen/css-to-inline-styles\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:33:\"tijsverkoyen/css-to-inline-styles\";s:10:\"\0*\0version\";s:5:\"2.4.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:73:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\tijsverkoyen\\css-to-inline-styles\";}s:16:\"vlucas/phpdotenv\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"vlucas/phpdotenv\";s:10:\"\0*\0version\";s:5:\"5.7.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\vlucas\\phpdotenv\";}s:19:\"voku/portable-ascii\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"voku/portable-ascii\";s:10:\"\0*\0version\";s:5:\"2.1.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\voku\\portable-ascii\";}s:15:\"composer/semver\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"composer/semver\";s:10:\"\0*\0version\";s:5:\"3.5.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\composer\\semver\";}s:14:\"fakerphp/faker\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"fakerphp/faker\";s:10:\"\0*\0version\";s:6:\"1.24.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.23\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\fakerphp\\faker\";}s:11:\"filp/whoops\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"filp/whoops\";s:10:\"\0*\0version\";s:6:\"2.18.6\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\filp\\whoops\";}s:21:\"hamcrest/hamcrest-php\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:21:\"hamcrest/hamcrest-php\";s:10:\"\0*\0version\";s:5:\"3.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:61:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\hamcrest\\hamcrest-php\";}s:22:\"laravel/agent-detector\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"laravel/agent-detector\";s:10:\"\0*\0version\";s:5:\"2.0.4\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\agent-detector\";}s:13:\"laravel/boost\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:13:\"laravel/boost\";s:10:\"\0*\0version\";s:6:\"2.10.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^2.10\";s:7:\"\0*\0path\";s:53:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\boost\";}s:11:\"laravel/mcp\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"1.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\mcp\";}s:12:\"laravel/pail\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"laravel/pail\";s:10:\"\0*\0version\";s:5:\"1.2.7\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^1.2.5\";s:7:\"\0*\0path\";s:52:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\pail\";}s:11:\"laravel/pao\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"laravel/pao\";s:10:\"\0*\0version\";s:5:\"1.1.5\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^1.0.6\";s:7:\"\0*\0path\";s:51:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\pao\";}s:12:\"laravel/pint\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.32.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.27\";s:7:\"\0*\0path\";s:52:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\pint\";}s:14:\"laravel/roster\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"laravel/roster\";s:10:\"\0*\0version\";s:5:\"1.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\laravel\\roster\";}s:15:\"mockery/mockery\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"mockery/mockery\";s:10:\"\0*\0version\";s:6:\"1.6.15\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^1.6\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\mockery\\mockery\";}s:17:\"myclabs/deep-copy\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"myclabs/deep-copy\";s:10:\"\0*\0version\";s:6:\"1.14.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\myclabs\\deep-copy\";}s:20:\"nunomaduro/collision\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"nunomaduro/collision\";s:10:\"\0*\0version\";s:5:\"8.9.5\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^8.6\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\nunomaduro\\collision\";}s:16:\"phar-io/manifest\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:16:\"phar-io/manifest\";s:10:\"\0*\0version\";s:5:\"2.0.4\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:56:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phar-io\\manifest\";}s:15:\"phar-io/version\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"phar-io/version\";s:10:\"\0*\0version\";s:5:\"3.2.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phar-io\\version\";}s:25:\"phpunit/php-code-coverage\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"phpunit/php-code-coverage\";s:10:\"\0*\0version\";s:6:\"12.5.8\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\php-code-coverage\";}s:25:\"phpunit/php-file-iterator\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"phpunit/php-file-iterator\";s:10:\"\0*\0version\";s:5:\"6.0.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\php-file-iterator\";}s:19:\"phpunit/php-invoker\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"phpunit/php-invoker\";s:10:\"\0*\0version\";s:5:\"6.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:59:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\php-invoker\";}s:25:\"phpunit/php-text-template\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:25:\"phpunit/php-text-template\";s:10:\"\0*\0version\";s:5:\"5.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\php-text-template\";}s:17:\"phpunit/php-timer\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"phpunit/php-timer\";s:10:\"\0*\0version\";s:5:\"8.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\php-timer\";}s:15:\"phpunit/phpunit\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"12.5.39\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:8:\"^12.5.12\";s:7:\"\0*\0path\";s:55:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\phpunit\\phpunit\";}s:20:\"sebastian/cli-parser\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"sebastian/cli-parser\";s:10:\"\0*\0version\";s:5:\"4.2.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\cli-parser\";}s:20:\"sebastian/comparator\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"sebastian/comparator\";s:10:\"\0*\0version\";s:5:\"7.1.8\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\comparator\";}s:20:\"sebastian/complexity\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:20:\"sebastian/complexity\";s:10:\"\0*\0version\";s:5:\"5.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:60:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\complexity\";}s:14:\"sebastian/diff\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"sebastian/diff\";s:10:\"\0*\0version\";s:5:\"7.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\diff\";}s:21:\"sebastian/environment\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:21:\"sebastian/environment\";s:10:\"\0*\0version\";s:5:\"8.1.2\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:61:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\environment\";}s:18:\"sebastian/exporter\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:18:\"sebastian/exporter\";s:10:\"\0*\0version\";s:5:\"7.0.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:58:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\exporter\";}s:22:\"sebastian/global-state\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:22:\"sebastian/global-state\";s:10:\"\0*\0version\";s:5:\"8.0.3\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:62:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\global-state\";}s:23:\"sebastian/lines-of-code\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:23:\"sebastian/lines-of-code\";s:10:\"\0*\0version\";s:5:\"4.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\lines-of-code\";}s:27:\"sebastian/object-enumerator\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:27:\"sebastian/object-enumerator\";s:10:\"\0*\0version\";s:5:\"7.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:67:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\object-enumerator\";}s:26:\"sebastian/object-reflector\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:26:\"sebastian/object-reflector\";s:10:\"\0*\0version\";s:5:\"5.0.0\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:66:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\object-reflector\";}s:27:\"sebastian/recursion-context\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:27:\"sebastian/recursion-context\";s:10:\"\0*\0version\";s:5:\"7.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:67:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\recursion-context\";}s:14:\"sebastian/type\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:14:\"sebastian/type\";s:10:\"\0*\0version\";s:5:\"6.0.4\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:54:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\type\";}s:17:\"sebastian/version\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"sebastian/version\";s:10:\"\0*\0version\";s:5:\"6.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\sebastian\\version\";}s:28:\"staabm/side-effects-detector\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:28:\"staabm/side-effects-detector\";s:10:\"\0*\0version\";s:5:\"1.0.5\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:68:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\staabm\\side-effects-detector\";}s:12:\"symfony/yaml\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"symfony/yaml\";s:10:\"\0*\0version\";s:6:\"7.4.21\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:52:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\symfony\\yaml\";}s:17:\"theseer/tokenizer\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"theseer/tokenizer\";s:10:\"\0*\0version\";s:5:\"2.0.1\";s:9:\"\0*\0source\";r:8;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\vendor\\theseer\\tokenizer\";}}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:115:{i:0;r:5;i:1;r:13;i:2;r:21;i:3;r:29;i:4;r:37;i:5;r:45;i:6;r:53;i:7;r:61;i:8;r:69;i:9;r:77;i:10;r:85;i:11;r:93;i:12;r:101;i:13;r:109;i:14;r:117;i:15;r:125;i:16;r:133;i:17;r:141;i:18;r:149;i:19;r:157;i:20;r:165;i:21;r:173;i:22;r:181;i:23;r:189;i:24;r:197;i:25;r:205;i:26;r:213;i:27;r:221;i:28;r:229;i:29;r:237;i:30;r:245;i:31;r:253;i:32;r:261;i:33;r:269;i:34;r:277;i:35;r:285;i:36;r:293;i:37;r:301;i:38;r:309;i:39;r:317;i:40;r:325;i:41;r:333;i:42;r:341;i:43;r:349;i:44;r:357;i:45;r:365;i:46;r:373;i:47;r:381;i:48;r:389;i:49;r:397;i:50;r:405;i:51;r:413;i:52;r:421;i:53;r:429;i:54;r:437;i:55;r:445;i:56;r:453;i:57;r:461;i:58;r:469;i:59;r:477;i:60;r:485;i:61;r:493;i:62;r:501;i:63;r:509;i:64;r:517;i:65;r:525;i:66;r:533;i:67;r:541;i:68;r:549;i:69;r:557;i:70;r:565;i:71;r:573;i:72;r:581;i:73;r:589;i:74;r:597;i:75;r:605;i:76;r:613;i:77;r:621;i:78;r:629;i:79;r:637;i:80;r:645;i:81;r:653;i:82;r:661;i:83;r:669;i:84;r:677;i:85;r:685;i:86;r:693;i:87;r:701;i:88;r:709;i:89;r:717;i:90;r:725;i:91;r:733;i:92;r:741;i:93;r:749;i:94;r:757;i:95;r:765;i:96;r:773;i:97;r:781;i:98;r:789;i:99;r:797;i:100;r:805;i:101;r:813;i:102;r:821;i:103;r:829;i:104;r:837;i:105;r:845;i:106;r:853;i:107;r:861;i:108;r:869;i:109;r:877;i:110;r:885;i:111;r:893;i:112;r:901;i:113;r:909;i:114;r:917;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:2:\"js\";O:37:\"Laravel\\Roster\\Ecosystems\\JsEcosystem\":3:{s:9:\"\0*\0byName\";a:6:{s:17:\"@tailwindcss/vite\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:17:\"@tailwindcss/vite\";s:10:\"\0*\0version\";s:5:\"4.0.0\";s:9:\"\0*\0source\";E:38:\"Laravel\\Roster\\Enums\\PackageSource:Npm\";s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^4.0.0\";s:7:\"\0*\0path\";s:63:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\@tailwindcss\\vite\";}s:12:\"concurrently\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:12:\"concurrently\";s:10:\"\0*\0version\";s:6:\"10.0.3\";s:9:\"\0*\0source\";r:1048;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:7:\"^10.0.3\";s:7:\"\0*\0path\";s:58:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\concurrently\";}s:19:\"laravel-vite-plugin\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:19:\"laravel-vite-plugin\";s:10:\"\0*\0version\";s:3:\"3.1\";s:9:\"\0*\0source\";r:1048;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^3.1\";s:7:\"\0*\0path\";s:65:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\laravel-vite-plugin\";}s:11:\"tailwindcss\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:5:\"4.0.0\";s:9:\"\0*\0source\";r:1048;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^4.0.0\";s:7:\"\0*\0path\";s:57:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\tailwindcss\";}s:4:\"vite\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:4:\"vite\";s:10:\"\0*\0version\";s:5:\"8.0.0\";s:9:\"\0*\0source\";r:1048;s:6:\"\0*\0dev\";b:1;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^8.0.0\";s:7:\"\0*\0path\";s:50:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\vite\";}s:18:\"@laravel/multiplex\";O:22:\"Laravel\\Roster\\Package\":7:{s:7:\"\0*\0name\";s:18:\"@laravel/multiplex\";s:10:\"\0*\0version\";s:5:\"0.4.1\";s:9:\"\0*\0source\";r:1048;s:6:\"\0*\0dev\";b:0;s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^0.4.1\";s:7:\"\0*\0path\";s:64:\"D:\\laragon\\www\\omniroute-laravel\\node_modules\\@laravel\\multiplex\";}}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:6:{i:0;r:1045;i:1;r:1053;i:2;r:1061;i:3;r:1069;i:4;r:1077;i:5;r:1085;}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:17:\"\0*\0packageManager\";N;}s:6:\"stacks\";O:30:\"Laravel\\Roster\\Support\\EnumSet\":1:{s:8:\"\0*\0cases\";a:1:{i:0;E:32:\"Laravel\\Roster\\Enums\\Stack:Blade\";}}s:21:\"browserTestFrameworks\";O:30:\"Laravel\\Roster\\Support\\EnumSet\":1:{s:8:\"\0*\0cases\";a:0:{}}s:9:\"frontends\";O:30:\"Laravel\\Roster\\Support\\EnumSet\":1:{s:8:\"\0*\0cases\";a:0:{}}s:6:\"agents\";O:30:\"Laravel\\Roster\\Support\\EnumSet\":1:{s:8:\"\0*\0cases\";a:2:{i:0;E:37:\"Laravel\\Roster\\Enums\\Agent:ClaudeCode\";i:1;E:32:\"Laravel\\Roster\\Enums\\Agent:Codex\";}}s:7:\"editors\";O:30:\"Laravel\\Roster\\Support\\EnumSet\":1:{s:8:\"\0*\0cases\";a:0:{}}}', 1792501282);

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

--
-- Dumping data for table `gateway_logs`
--

INSERT INTO `gateway_logs` (`id`, `gateway_key_id`, `requested_model`, `routed_provider`, `routed_model`, `account_label`, `prompt_tokens`, `completion_tokens`, `total_tokens`, `saved_tokens`, `cost_usd`, `cost_saved_usd`, `latency_ms`, `status_code`, `is_cached`, `redacted_pii_count`, `error_message`, `created_at`, `updated_at`) VALUES
(14, NULL, 'coding', 'river-ai', 'deepseek-ai/DeepSeek-V4.1-Flash', 'test', 15, 9, 24, 0, '0.000005', '0.000000', 1003, 200, 0, 0, NULL, '2026-10-20 05:48:21', '2026-10-20 05:48:21');

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
(10, '2026_10_19_180000_create_alert_settings_table', 7),
(11, '2026_10_20_100000_create_site_settings_table', 8),
(12, '2026_10_20_110000_drop_subtitle_from_site_settings_table', 9),
(13, '2026_10_20_120000_add_dark_light_logo_to_site_settings_table', 10);

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
(117, 111, 'test', 'eyJpdiI6InVnU21TNVdEejFta01MLzFjd2JMN2c9PSIsInZhbHVlIjoia0tsL1F2YlBBa0wzYzhkcXhkd0NlSTFQNzhPQ0RwQ1lUcWlkVGhDVEZmaVNtYTFBbWdzN0RSZWo4c1prSnBkaCIsIm1hYyI6ImJmNjlmNDUzYTM3NzQ3YjQ1ZWY5NWVmOGYyYzZlZDkzNTU3NDY4ZGJkYTRhODk2ZjEwODk1MjYwMTM4NzZiNGEiLCJ0YWciOiIifQ==', 1, NULL, 24, '2026-10-20', NULL, 0, NULL, 1, '2026-10-19 02:45:21', '2026-10-20 05:48:21'),
(118, 112, 'open-route', 'eyJpdiI6ImtUVFF0TnJ1SDE5L1RDdnpnaVFmOGc9PSIsInZhbHVlIjoidHJacTJQUkNzTEJ4V2FVdEZ0T1g0Si95STFoOFBtV29qYjJMNTk0cFNXcDZRanQ0ZHFqWGNEU244RG1TZTJVaU5weWlVcUpNVVFrczR4MGhSSEcrT05IQVN0MG1nK3EySVlBRndvRERKOHc9IiwibWFjIjoiNjViNThmZWY3OWJmNzhhMGI0MTZiMzAxYWE3ODY2NzBkYWE2YjAxYTFiN2QyM2MxOTgwM2ZjZjIxYmUyYmQ4NiIsInRhZyI6IiJ9', 1, NULL, 0, '2026-10-20', NULL, 0, NULL, 1, '2026-10-19 03:27:17', '2026-10-20 05:48:34');

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
('iuPoq5vWYJgdNnVj7YgfgxGBFMZZQosSGuKp0OqW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrZEVhOXlvNVA0akRvWWUxSWc0RWxMOVhJOXNIS0tub09BT0h1dTBRIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL29tbmlyb3V0ZS1sYXJhdmVsLnRlc3RcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1792497406);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OmniRoute',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'v1.0',
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_dark_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_light_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_title`, `version`, `logo_path`, `logo_dark_path`, `logo_light_path`, `favicon_path`, `created_at`, `updated_at`) VALUES
(3, 'OneKey AI', 'v1.0', 'branding/tA1ejXULmt8fucFpGhZIdxUMLol3C2KhhmGBJTVv.png', 'branding/oJnel3ObHYhF2sBSRZm73JDX97aSBlKVegl75FAb.png', 'branding/rW2rJZQ5cUAgjQ3uP6CsmQfGm1DGQQmrk30Vzqs1.png', 'branding/bWjbRVxsMi4PA1PTaGUCWtJGTRnATEnntfeZwwJQ.png', '2026-10-20 03:02:29', '2026-10-20 05:30:02');

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
(1, 'OmniRoute Admin', 'admin@gmail.com', '2026-10-19 05:06:34', '$2y$12$sLN01.CcP4h85dEDHFIETe27XuUXfqSP1KrLeDqkC6jKztQvP6R1a', 'JAIhtOrEm8ycZiaoI2QjauOG8qwlDkV6pnSm5xR0hrtgdbnah3zufexXx8gm', '2026-10-14 23:56:31', '2026-10-19 23:25:07');

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
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `model_pricings`
--
ALTER TABLE `model_pricings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `routing_combos`
--
ALTER TABLE `routing_combos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
