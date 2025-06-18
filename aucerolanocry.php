<?php

// Menu colorido e estilizado
system("clear");
echo "\n";
echo "       _           _           ____       \n";
echo "  / _ \\  ___  ___ _ __(_) ___  ___| |_ ___   \n";
echo " | | | |/ _ \\/ __| '__| |/ _ \\/ __| __/ __|  \n";
echo " | |_| |  __/ (__| |  | |  __/ (__| |_\\__ \\  \n";
echo "  \\___/ \\___|\\___|_|  |_|\\___|\\___|\\__|___/  \n";
echo "\n";
echo "       ===  AUCEROLA BAYPASS MENU  ===\n\n";
echo "[0] Instalar Módulos e Parear ADB\n";
echo "[1] Bypass Free Fire com Ajuste de Data e Log\n";
echo "[2] Sair\n\n";
echo "[#] Escolha uma das opções acima: ";
$opcao = trim(fgets(STDIN));

if ($opcao == "0") {
    echo "\n📦 Instalando módulos necessários...\n";
    system("pkg install git php android-tools -y");
    echo "\n🔌 Iniciando conexão ADB...\n";
    system("adb devices");
    echo "✅ ADB pronto!\n";
}
elseif ($opcao == "1") {
    echo "\n[*] Executando função de bypass direta...\n";

    $script = <<<SH
#!/system/bin/sh

ORIG="/storage/emulated/0/Pictures/100PINT/PINS/AUCEROLABAY/com.dts.freefireth"
DEST="/storage/emulated/0/Android/data/com.dts.freefireth"
data="20250528"

# Verifica origem
if [ ! -d "\$ORIG" ]; then
    echo "❌ Erro: pasta limpa não encontrada."
    exit 1
else
    echo "✅ Pasta limpa encontrada."
fi

# Abre configurações de Data e Hora
echo "⏳ Abrindo configurações de Data e Hora..."
am start -a android.settings.DATE_SETTINGS
sleep 2
echo "🕐 Ajuste a data/hora e pressione ENTER para continuar."
read

# Copia a pasta limpa
if cp -rf "\$ORIG/"* "\$DEST/" 2>/dev/null; then
    echo "✅ Pasta limpa aplicada."
else
    echo "❌ Erro ao copiar a pasta limpa."
    exit 1
fi

# Ajusta datas com touch
ajustou=1
for linha in \\
    "\$DEST/files/ShaderStripSettings \${data}0930.00" \\
    "\$DEST/files \${data}0945.00" \\
    "\$DEST/files/contentcache \${data}1005.00" \\
    "\$DEST/files/contentcache/optional \${data}1015.00" \\
    "\$DEST/files/contentcache/optional/android \${data}1025.00" \\
    "\$DEST/files/contentcache/optional/android/gameassetbundles \${data}1035.00" \\
    "\$DEST/files/contentcache/optional/android/optionalavatarres \${data}1040.00" \\
    "\$DEST \${data}1045.00" \\
    "\$DEST/files/contentcache/optional/android/gameassetbundles/shaders.t4NwpizuffoEtxXrXzvYaKh4HQ8~3D \${data}1055.00"
do
    caminho=\$(echo "\$linha" | awk '{print \$1}')
    horario=\$(echo "\$linha" | awk '{print \$2}')
    if [ -e "\$caminho" ]; then
        touch -t "\$horario" "\$caminho" 2>/dev/null
    else
        ajustou=0
        echo "❌ Caminho não encontrado: \$caminho"
    fi
done

if [ "\$ajustou" -eq 1 ]; then
    echo "✅ Datas ajustadas com sucesso."
else
    echo "⚠️ Algumas datas não puderam ser ajustadas."
fi

# Reabre Data e Hora
echo "🕐 Reabrindo configurações de Data e Hora para ativação manual..."
am start -a android.settings.DATE_SETTINGS
sleep 2
echo "✅ Pressione ENTER após ativar novamente."
read

# Limpa logcat
echo "🧹 Limpando logcat com adb logcat -c..."
logcat -c
echo "✅ Logcat limpo."

# Abre Depuração via Wi-Fi
echo "📡 Abrindo tela de Depuração via Wi-Fi..."
am start -n com.android.settings/.AdbWirelessSettings
sleep 2
echo "✅ Pressione ENTER após verificar a depuração."
read

# Finaliza
clear
echo "✅ Script concluído com sucesso."
SH;

    file_put_contents("/tmp/aucerola_bypass.sh", $script);
    chmod("/tmp/aucerola_bypass.sh", 0777);
    system("adb shell < /tmp/aucerola_bypass.sh");
}
elseif ($opcao == "2") {
    echo "\n👋 Saindo...\n";
    exit;
}
else {
    echo "\n❌ Opção inválida.\n";
}
