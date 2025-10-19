# Contributing to Template Management System

Thank you for considering contributing to this project!

## 📋 Table of Contents

-   [Code of Conduct](#code-of-conduct)
-   [Getting Started](#getting-started)
-   [Development Workflow](#development-workflow)
-   [Coding Standards](#coding-standards)
-   [Pull Request Process](#pull-request-process)
-   [Bug Reports](#bug-reports)
-   [Feature Requests](#feature-requests)

## 🤝 Code of Conduct

This project follows a Code of Conduct. By participating, you are expected to uphold this code.

### Our Standards

-   Be respectful and inclusive
-   Accept constructive criticism gracefully
-   Focus on what is best for the community
-   Show empathy towards other contributors

## 🚀 Getting Started

1. **Fork the repository**

    ```bash
    # Click "Fork" button on GitHub
    ```

2. **Clone your fork**

    ```bash
    git clone https://github.com/YOUR-USERNAME/Templatein_Ai.git
    cd Templatein_Ai
    ```

3. **Add upstream remote**

    ```bash
    git remote add upstream https://github.com/Indraaai/Templatein_Ai.git
    ```

4. **Setup development environment**
    ```bash
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate:fresh --seed
    npm run dev
    ```

## 🔄 Development Workflow

### 1. Create a Feature Branch

```bash
# Update your fork
git checkout main
git pull upstream main

# Create feature branch
git checkout -b feature/your-feature-name
# or
git checkout -b fix/bug-description
```

### 2. Make Changes

-   Write clean, readable code
-   Follow existing code style
-   Add comments for complex logic
-   Write tests for new features
-   Update documentation

### 3. Commit Changes

```bash
git add .
git commit -m "feat: add new feature description"
```

**Commit Message Format:**

```
type(scope): subject

body (optional)

footer (optional)
```

**Types:**

-   `feat`: New feature
-   `fix`: Bug fix
-   `docs`: Documentation only
-   `style`: Code style changes (formatting, etc.)
-   `refactor`: Code refactoring
-   `test`: Adding or updating tests
-   `chore`: Maintenance tasks

**Examples:**

```bash
git commit -m "feat(template): add live preview functionality"
git commit -m "fix(student): resolve dropdown not loading issue"
git commit -m "docs(readme): update installation steps"
```

### 4. Push Changes

```bash
git push origin feature/your-feature-name
```

### 5. Create Pull Request

1. Go to your fork on GitHub
2. Click "New Pull Request"
3. Select your feature branch
4. Fill in PR template
5. Submit PR

## 📝 Coding Standards

### PHP (Laravel)

-   Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
-   Use type hints and return types
-   Write PHPDoc comments for classes and methods
-   Keep methods small and focused
-   Use dependency injection

**Example:**

```php
<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Collection;

class TemplateService
{
    /**
     * Get active templates by faculty.
     *
     * @param int $facultyId
     * @return Collection
     */
    public function getActiveTemplatesByFaculty(int $facultyId): Collection
    {
        return Template::where('faculty_id', $facultyId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}
```

### JavaScript

-   Use ES6+ syntax
-   Use `const` and `let`, avoid `var`
-   Use arrow functions where appropriate
-   Add JSDoc comments for functions
-   Use meaningful variable names

**Example:**

```javascript
/**
 * Load program studies by faculty ID
 * @param {number} facultyId - The faculty ID
 * @returns {Promise<Array>} Program studies
 */
const loadProgramStudies = async (facultyId) => {
    try {
        const response = await fetch(`/api/program-studies/${facultyId}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error loading program studies:", error);
        throw error;
    }
};
```

### Blade Templates

-   Keep logic minimal in views
-   Use components for reusable UI
-   Follow indentation consistently
-   Use semantic HTML

**Example:**

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach ($templates as $template)
            <x-template-card :template="$template" />
        @endforeach
    </div>
</x-app-layout>
```

### CSS/TailwindCSS

-   Use TailwindCSS utility classes
-   Create custom components in `app.css` only when necessary
-   Follow mobile-first approach
-   Use consistent spacing scale

## 🧪 Testing

### Write Tests

-   Write unit tests for services and models
-   Write feature tests for controllers
-   Aim for >80% code coverage
-   Test edge cases and error conditions

**Example:**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Faculty;

class StudentManagementTest extends TestCase
{
    public function test_admin_can_create_student(): void
    {
        $admin = User::factory()->admin()->create();
        $faculty = Faculty::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/students', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'faculty_id' => $faculty->id,
        ]);

        $response->assertRedirect('/admin/students');
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
```

### Run Tests

```bash
# All tests
php artisan test

# Specific test
php artisan test --filter StudentManagementTest

# With coverage
php artisan test --coverage
```

## 📤 Pull Request Process

### Before Submitting

-   [ ] Tests pass locally
-   [ ] Code follows style guidelines
-   [ ] Documentation is updated
-   [ ] No merge conflicts with main
-   [ ] Commit messages are clear

### PR Template

```markdown
## Description

Brief description of what this PR does

## Type of Change

-   [ ] Bug fix
-   [ ] New feature
-   [ ] Breaking change
-   [ ] Documentation update

## Testing

How has this been tested?

## Checklist

-   [ ] Tests pass
-   [ ] Code follows style guide
-   [ ] Documentation updated
-   [ ] No breaking changes

## Screenshots (if applicable)
```

### Review Process

1. Automated tests will run
2. Maintainer will review code
3. Address feedback if needed
4. PR will be merged or closed

## 🐛 Bug Reports

### Before Reporting

-   Check if bug already reported
-   Try to reproduce the bug
-   Collect relevant information

### Bug Report Template

```markdown
**Describe the bug**
Clear description of the bug

**To Reproduce**
Steps to reproduce:

1. Go to '...'
2. Click on '...'
3. See error

**Expected behavior**
What you expected to happen

**Screenshots**
If applicable, add screenshots

**Environment:**

-   OS: [e.g., Windows 11]
-   Browser: [e.g., Chrome 120]
-   Laravel Version: [e.g., 11.0]

**Additional context**
Any other context about the problem
```

## 💡 Feature Requests

### Feature Request Template

```markdown
**Is your feature request related to a problem?**
Clear description of the problem

**Describe the solution you'd like**
Clear description of what you want to happen

**Describe alternatives you've considered**
Other solutions you've thought about

**Additional context**
Screenshots, mockups, or examples
```

## 📚 Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [TailwindCSS Documentation](https://tailwindcss.com/docs)
-   [PSR-12 Coding Style](https://www.php-fig.org/psr/psr-12/)
-   [Conventional Commits](https://www.conventionalcommits.org/)

## ❓ Questions?

If you have questions, please:

1. Check existing documentation
2. Search closed issues
3. Open a new discussion

## 🙏 Thank You

Thank you for contributing to this project! Your help is appreciated.

---

**Happy Coding! 🚀**
