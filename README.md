# Laravel AI CLI

AI-powered CLI tools for Laravel using the Laravel AI SDK. This package provides intelligent commands for asking questions, explaining errors, and reviewing code directly from your terminal.

## Features

- **Ask Agent** (`ai:ask`) - Ask AI a question about your code or any topic
- **Explain Agent** (`ai:explain`) - Understand application errors and log files
- **Review Agent** (`ai:review`) - Get code reviews from an AI senior engineer

## Requirements

- PHP ^8.2
- Laravel ^12.0
- Laravel AI SDK ^0.1

## Installation

### 1. Add the Package to Your Laravel Project

```bash
composer require laravel-ai/cli:@dev
```

The package will be automatically discovered by Laravel via service provider auto-discovery.

### 2. Configure Your AI Provider

The package uses Laravel's AI SDK. Configure your AI provider in your `.env` file:

```env
# For OpenAI
OPENAI_API_KEY=your-api-key-here

# Or for other supported providers
AI_PROVIDER=openai
```

## Usage

### Ask a Question

Ask the AI assistant any question:

```bash
php artisan ai:ask "What are the best practices for Laravel security?"
```

### Explain an Error

Get a clear explanation of error messages or log files:

```bash
php artisan ai:explain /path/to/error-log.txt
```

Example:

```bash
php artisan ai:explain storage/logs/laravel.log
```

### Review Code

Get feedback on your code from an AI senior engineer:

```bash
php artisan ai:review /path/to/your/file.php
```

Example:

```bash
php artisan ai:review app/Models/User.php
```

## Command Details

### ai:ask

```bash
php artisan ai:ask {prompt}
```

**Arguments:**

- `prompt` - Your question for the AI

**Example:**

```bash
php artisan ai:ask "How do I implement dependency injection in Laravel?"
```

---

### ai:explain

```bash
php artisan ai:explain {file}
```

**Arguments:**

- `file` - Path to the error or log file to explain

**Example:**

```bash
php artisan ai:explain storage/logs/laravel.log
```

---

### ai:review

```bash
php artisan ai:review {file}
```

**Arguments:**

- `file` - Path to the source code file to review

**Example:**

```bash
php artisan ai:review app/Http/Controllers/UserController.php
```

## Package Structure

```
src/
├── AiCliServiceProvider.php      # Service provider (auto-discovered)
├── Commands/
│   ├── AskCommand.php            # Ask question command
│   ├── ExplainCommand.php        # Explain errors command
│   └── ReviewCommand.php         # Code review command
└── Ai/
    └── Agents/
        ├── AskAgent.php          # AI agent for questions
        ├── ExplainAgent.php      # AI agent for explanations
        └── ReviewAgent.php       # AI agent for code reviews
```

## How It Works

1. **Service Provider** - Auto-loads commands on Laravel startup
2. **Commands** - Handle CLI input and file reading
3. **Agents** - Implement the AI logic with specific instructions for each task
4. **Laravel AI SDK** - Handles communication with the AI provider

Each agent uses the `Promptable` trait and implements the `Agent` interface, providing specific instructions to the AI for better results.

## Configuration

The package respects your Laravel AI configuration. You can customize behavior by:

1. Setting environment variables for your AI provider
2. Modifying agent instructions in the respective Agent classes

## Troubleshooting

### "File not found" Error

Ensure the file path is correct and relative to your Laravel project root:

```bash
# Correct - relative to project root
php artisan ai:explain storage/logs/laravel.log

# Correct - absolute path
php artisan ai:explain /full/path/to/file.log
```

### "Undefined type" IDE Errors

Run the following to regenerate autoloader files:

```bash
composer dump-autoload
```

### AI Response is Empty

1. Verify your API key is set in `.env`
2. Check your API quota/credits
3. Ensure the file exists and is readable

## License

MIT License. See LICENSE file for details.

## Support

For issues or feature requests, please open an issue on the repository.
