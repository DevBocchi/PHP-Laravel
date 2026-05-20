<?php

/**
 * Migration: Criação das tabelas iniciais do sistema.
 *
 * Este arquivo foi gerado automaticamente pelo Artisan. Para criar uma nova migration, use:
 *   php artisan make:migration nome_da_migration
 *
 * Para executar todas as migrations pendentes e atualizar o banco de dados, use:
 *   php artisan migrate
 *
 * Tabelas criadas nesta migration:
 *
 * - users:
 *     - id              → chave primária auto-incremental
 *     - name            → nome do usuário (string)
 *     - email           → e-mail único do usuário (string)
 *     - email_verified_at → data de verificação do e-mail (timestamp, nullable)
 *     - password        → senha criptografada (string)
 *     - remember_token  → token para "lembrar sessão" (gerado por rememberToken())
 *     - created_at / updated_at → timestamps automáticos (gerados por timestamps())
 *
 * - password_reset_tokens:
 *     - email           → e-mail como chave primária (string)
 *     - token           → token de redefinição de senha (string)
 *     - created_at      → data de criação do token (timestamp, nullable)
 *
 * - sessions:
 *     - id              → identificador da sessão como chave primária (string)
 *     - user_id         → referência opcional ao usuário (foreignId, nullable)
 *     - ip_address      → endereço IP do cliente (string 45, nullable)
 *     - user_agent      → informações do navegador/cliente (text, nullable)
 *     - payload         → dados da sessão serializados (longText)
 *     - last_activity   → timestamp da última atividade (integer, indexado)
 */

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
