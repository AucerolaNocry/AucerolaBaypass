<?php
// Aucerola Baypass - Menu Simples
system("clear"); // Limpa a tela (funciona em sistemas Unix)

echo "\n";
echo "+----------------------------------------------+\n";
echo "+           Aucerola Baypass Menu              +\n";
echo "+----------------------------------------------+\n";
echo "\n";
echo "[0] Instalar Módulos (Atualizar e instalar módulos)\n";
echo "[1] Baypass Free Fire Normal\n";
echo "[2] Baypass Free Fire Max\n";
echo "[S] Sair\n";
echo "\n";
echo "[#] Escolha uma das opções acima: ";
$opcao = trim(fgets(STDIN));

switch ($opcao) {
    case '0':
        echo "\nInstalando módulos...\n";
        // Coloque os comandos de instalação aqui se quiser
        break;
    case '1':
        echo "\nExecutando Baypass Free Fire Normal...\n";
        // Código do Baypass Free Fire Normal aqui
        break;
    case '2':
        echo "\nExecutando Baypass Free Fire Max...\n";
        // Código do Baypass Free Fire Max aqui
        break;
    case 'S':
    case 's':
        echo "\nSaindo...\n";
        exit;
        break;
    default:
        echo "\nOpção inválida!\n";
        break;
}
