<?php

namespace App\Infrastructure\ValueObjects;

final class Cpf
{
    private string $cpf;

    public function __construct(string $incomingCpf)
    {
        $digits = preg_replace('/\D/', '', $incomingCpf);

        if (!$this->isValidCpf($digits)) {
            throw new \InvalidArgumentException("CPF inválido: {$incomingCpf}. Digite um CPF verdadeiro");
        }

        $this->cpf = $this->format($digits);
    }

    public function __toString (): string
    {
        return $this->cpf;
    }

    private function isValidCpf(string $cpf): bool
    {
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private function format(string $cpf): string
    {
        return substr($cpf, 0, 3) . '.' .
               substr($cpf, 3, 3) . '.' .
               substr($cpf, 6, 3) . '-' .
               substr($cpf, 9, 2);
    }
}
