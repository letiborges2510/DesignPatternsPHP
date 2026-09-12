<?php

declare(strict_types=1);

namespace DesignPatterns\Structural\Adapter;

/**
 * Esta é a classe adaptadora. Note que ela implementa Book,
 * portanto o código cliente que usa Book não precisa ser alterado.
 */
class EBookAdapter implements Book
{
    public function __construct(protected EBook $eBook)
    {
    }

    /**
     * Traduz a chamada esperada pelo cliente (open) para o método
     * real da classe adaptada (unlock).
     */
    public function open(): void
    {
        $this->eBook->unlock();
    }

    /**
     * Traduz turnPage() para pressNext().
     */
    public function turnPage(): void
    {
        $this->eBook->pressNext();
    }

    /**
     * Aqui está o ponto mais interessante do adapter: EBook::getPage()
     * retorna um array [páginaAtual, totalDePáginas], mas Book espera
     * apenas um int com a página atual. O adapter faz essa conversão.
     */
    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}