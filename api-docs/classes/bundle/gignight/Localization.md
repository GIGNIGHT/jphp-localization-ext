## Localization

* #### Class ``` Localization ```
* #### Package ``` localization ```
---

### Properties
* ``` ->defaultLang ``` : ``` string ```
* ``` ->defaultPath ``` : ``` string ```
* ``` ->fullPath ``` : ``` string ```

## Methods

### __construct()
####
```php
__construct(string $langCode = 'ru'): void
```
### getCurrentLanguage()
```php
getCurrentLanguage(): string
```
### getDirectory()
```php
getDirectory(): string
```
### set()
```php
set(string $line, ?string $value): Localization
```
### setAll()
```php
setAll(array $lines): bool
```
### save()
```php
save(): bool
```
### get()
```php
get($line, ...$params): ?string
```
### getAll()
```php
getAll(): array
```
