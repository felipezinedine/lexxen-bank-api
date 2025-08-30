<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UserStatusCommand extends Command
{
    /**
     * Nome e assinatura do comando
     */
    protected $signature = 'user:status {email} {status}';

    /**
     * Descrição do comando
     */
    protected $description = 'Atualiza o status de um usuário (approved, failed, waiting)';

    /**
     * Executa o comando
     */
    public function handle()
    {
        $email = $this->argument('email');
        $status = $this->argument('status');

        $validStatuses = ['approved', 'failed', 'waiting'];

        if (!in_array($status, $validStatuses)) {
            $this->error("Status inválido. Use: " . implode(', ', $validStatuses));
            return;
        }

        $user = User::where('email', '=', $email)->first();

        if (!$user) {
            $this->error("Usuário não encontrado.");
            return;
        }

        $user->status = $status;
        $user->save();

        $this->info("Usuário #{$user->id} atualizado para status: {$status}");
    }
}
