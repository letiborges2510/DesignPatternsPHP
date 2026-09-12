# Padrão de Projeto Adapter — Book / EBook / Kindle

Atividade da disciplina de Modelagem de Padrões de Projeto, implementando o
padrão estrutural **Adapter** em PHP, com base no projeto
[DesignPatternsPHP](https://github.com/DesignPatternsPHP/DesignPatternsPHP).

Alunas: Leticia Borges e Yasmin Oliveira.

## Objetivo

O código cliente que consome a interface `Book` não consegue interagir
diretamente com instâncias de `Kindle`, pois este implementa a interface
`EBook`, que possui nomes de métodos e tipos de retorno diferentes.

O objetivo desta atividade foi criar uma classe adaptadora que, utilizando
**composição**, traduz as chamadas da interface esperada pelo cliente
(`Book`, o *Target*) para os métodos da classe externa (`EBook`/`Kindle`,
o *Adaptee*).

## Identificação do conflito

| Interface `Book` (esperada pelo cliente) | Interface `EBook` (implementada por `Kindle`) |
|---|---|
| `open()` | `unlock()` |
| `turnPage()` | `pressNext()` |
| `getPage(): int` | `getPage(): array` (retorna `[páginaAtual, totalPáginas]`) |

## Passos executados

### 1. Clonagem do repositório base
```bash
git clone https://github.com/DesignPatternsPHP/DesignPatternsPHP.git
cd DesignPatternsPHP
```

### 2. Instalação do ambiente (PHP + Composer)
Foi necessário instalar o PHP via **XAMPP** e o **Composer**, além de
habilitar a extensão `zip` no `php.ini` (estava desativada por padrão),
já que o Composer depende dela para baixar pacotes.

```bash
composer install
```

### 3. Criação da classe adaptadora
Arquivo criado em `Structural/Adapter/EBookAdapter.php`:

```php
<?php

declare(strict_types=1);

namespace DesignPatterns\Structural\Adapter;

/**
 * Classe adaptadora. Implementa Book, portanto o código cliente que
 * usa Book não precisa ser alterado para funcionar com um Kindle.
 */
class EBookAdapter implements Book
{
    public function __construct(protected EBook $eBook)
    {
    }

    public function open(): void
    {
        $this->eBook->unlock();
    }

    public function turnPage(): void
    {
        $this->eBook->pressNext();
    }

    /**
     * EBook::getPage() retorna [páginaAtual, total], mas Book espera
     * apenas a página atual como int — o adapter faz essa tradução.
     */
    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}
```

### 4. Implementação do contrato via composição
A classe implementa a interface `Book` (mantendo compatibilidade com o
cliente) e recebe uma instância de `EBook` por **injeção de dependência**
no construtor, em vez de herdar de `Kindle` — isso é o que caracteriza o
uso de composição no padrão Adapter.

### 5. Testes
```bash
php Structural/Adapter/Tests/AdapterTest.php
```
Saída obtida: `2` (página após abrir o livro e virar uma página),
confirmando que o adapter traduz corretamente as chamadas para o `Kindle`.

## Resultado

Com o `EBookAdapter`, o código cliente pode usar:

```php
$kindle = new Kindle();
$book = new EBookAdapter($kindle);

$book->open();
$book->turnPage();
echo $book->getPage(); // 2
```

...sem precisar conhecer os detalhes internos do `Kindle`, exatamente como
faria com um `PaperBook` comum.

## Autoras
- Letícia Borges e Yasmin Pereira
