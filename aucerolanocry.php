<?php
// Cores de terminal
$corPadrao = "\033[0m";
$negrito = "\033[1m";
$verde = "\033[32m";
$vermelho = "\033[31m";
$amarelo = "\033[33m";
$azul = "\033[36m";
$branco = "\033[97m";

// Função Banner igual ao KellerSS.php
function exibirBanner() {
    global $azul, $corPadrao, $negrito;
    echo $azul . $negrito;
    echo "--------------------------------------\n";
    echo "          KellerSS SCANNER            \n";
    echo "        Coded By - KellerSS           \n";
    echo "        Credits: Sheik                \n";
    echo "--------------------------------------\n";
    echo $corPadrao;
}

// Exibe menu principal igual ao original (com as mesmas opções)
function exibirMenu() {
    global $negrito, $corPadrao, $verde, $amarelo, $vermelho;
    echo $negrito . $verde . "[30] Scanner completo (Logs e Arquivos)\n" . $corPadrao;
    echo $negrito . $amarelo . "[31] Scanner rápido (Arquivos)\n" . $corPadrao;
    echo $negrito . $azul . "[32] Scanner avançado (Pastas extras)\n" . $corPadrao;
    echo $negrito . $vermelho . "[53] Atualizar script\n" . $corPadrao;
    echo $corPadrao . "[0] Sair\n";
    echo "Escolha uma das opções acima: ";
}

// Início do script
system('clear');
exibirBanner();
exibirMenu();

// Aqui pode vir o switch/case para cada opção, exemplo:
$opcao = trim(fgets(STDIN));
switch ($opcao) {
    case "30":
        // Chamar função do scanner completo
        // scannerCompleto();
        break;
    case "31":
        // scannerRapido();
        break;
    case "32":
        // scannerAvancado();
        break;
    case "53":
        // atualizarScript();
        break;
    case "0":
        echo "Saindo...\n";
        exit;
    default:
        echo $vermelho . "[!] Opção inválida.\n" . $corPadrao;
        // Reexibe menu se quiser
        break;
}
