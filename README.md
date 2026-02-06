# Laravel AI CLI

AI-powered CLI tools for Laravel using the Laravel AI SDK. This package provides intelligent commands for asking questions, explaining errors, and reviewing code directly from your terminal.

## Features

- **Ask Agent** (`ai:ask`) - Ask AI a question about your code or any topic
- **Explain Agent** (`ai:explain`) - Understand application errors and log files
- **Review Agent** (`ai:review`) - Get code reviews from an AI senior engineer
- **Optimize Agent** (`ai:optimize`) - Optimize code for performance and efficiency
- **Refactor Agent** (`ai:refactor`) - Refactor code for better quality and maintainability
- **Document Agent** (`ai:document`) - Generate comprehensive markdown documentation (display in terminal or save to file)

## Requirements

- PHP ^8.2
- Laravel ^12.0
- Laravel AI SDK ^0.1

## Installation

### 1. Add the Package to Your Laravel Project

```bash
composer require laravel-ai/cli
```

The package will be automatically discovered by Laravel via service provider auto-discovery.

### 2. Configure Your AI Provider

**Currently Supported:** OpenAI

Configure your OpenAI API key in your `.env` file:

```env
OPENAI_API_KEY=sk-proj-your-api-key-here
```

**Coming Soon:** More providers including Anthropic Claude, Google Gemini, and Cohere will be integrated in upcoming releases.

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

### ai:optimize

```bash
php artisan ai:optimize {file}
```

**Arguments:**

- `file` - Path to the source code file to optimize

**Example:**

```bash
php artisan ai:optimize app/Models/User.php
```

---

### ai:refactor

```bash
php artisan ai:refactor {file}
```

**Arguments:**

- `file` - Path to the source code file to refactor

**Example:**

```bash
php artisan ai:refactor app/Http/Controllers/ProductController.php
```

---

### ai:document

```bash
php artisan ai:document {file}
```

Generates comprehensive markdown documentation. The command will prompt you to choose how to receive the documentation:

**Arguments:**

- `file` - Path to the source code file to document

**Output Options:**

1. **Display in Terminal** - View formatted markdown directly in your terminal
2. **Save to File** - Save as `DOCUMENTATION_{filename}.md` in project root

**Example:**

```bash
php artisan ai:document app/Services/PaymentService.php

How would you like to receive the documentation?:
  [0] Display in terminal
  [1] Save to file (DOCUMENTATION_PaymentService.md)
 > 1
```

The generated documentation includes:

- Detailed overview and purpose
- PHPDoc style comments
- Parameter documentation
- Usage examples with code blocks
- Important notes and edge cases
- Related files references

## Package Structure

```
src/
├── AiCliServiceProvider.php            # Service provider (auto-discovered)
├── Commands/
│   ├── AskCommand.php                  # Ask question command
│   ├── DocumentCommand.php             # Generate documentation command
│   ├── DocumentMarkdownCommand.php     # Generate markdown documentation & save to file
│   ├── ExplainCommand.php              # Explain errors command
│   ├── OptimizeCommand.php             # Optimize code command
│   ├── RefactorCommand.php             # Refactor code command
│   └── ReviewCommand.php               # Code review command
└── Ai/
    └── Agents/
        ├── AskAgent.php                # AI agent for questions
        ├── DocumentAgent.php           # AI agent for documentation (plain text)
        ├── ExplainAgent.php            # AI agent for explanations
        ├── MarkdownDocumentAgent.php   # AI agent for markdown documentation
        ├── OptimizeAgent.php           # AI agent for optimization
        ├── RefactorAgent.php           # AI agent for refactoring
        └── ReviewAgent.php             # AI agent for code reviews
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
