<?php
     /**
    4 + * Migration: Criação das tabelas iniciais do sistema.
    5 + *
    6 + * Este arquivo foi gerado automaticamente pelo Artisan. Para criar uma nova migration, use:
    7 + *   php artisan make:migration nome_da_migration
    8 + *
    9 + * Para executar todas as migrations pendentes e atualizar o banco de dados, use:
    10 + *   php artisan migrate
    11 + *
    12 + * Tabelas criadas nesta migration:
    13 + *
    14 + * - users:
    15 + *     - id              → chave primária auto-incremental
    16 + *     - name            → nome do usuário (string)
    17 + *     - email           → e-mail único do usuário (string)
    18 + *     - email_verified_at → data de verificação do e-mail (timestamp, nullable)
    19 + *     - password        → senha criptografada (string)
    20 + *     - remember_token  → token para "lembrar sessão" (gerado por rememberToken())
    21 + *     - created_at / updated_at → timestamps automáticos (gerados por timestamps())
    22 + *
    23 + * - password_reset_tokens:
    24 + *     - email           → e-mail como chave primária (string)
    25 + *     - token           → token de redefinição de senha (string)
    26 + *     - created_at      → data de criação do token (timestamp, nullable)
    27 + *
    28 + * - sessions:
    29 + *     - id              → identificador da sessão como chave primária (string)
    30 + *     - user_id         → referência opcional ao usuário (foreignId, nullable)
    31 + *     - ip_address      → endereço IP do cliente (string 45, nullable)
    32 + *     - user_agent      → informações do navegador/cliente (text, nullable)
    33 + *     - payload         → dados da sessão serializados (longText)
    34 + *     - last_activity   → timestamp da última atividade (integer, indexado)
    35 + */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 128);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
