#!/bin/bash

# Script de Migración Automática Laravel 6 → Laravel 11
# Uso: bash migrate.sh

set -e

echo "🚀 Iniciando migración de Laravel 6 a Laravel 11..."
echo ""

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Verificar que estamos en un proyecto Laravel
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: No se encuentra el archivo artisan. ¿Estás en la raíz del proyecto?${NC}"
    exit 1
fi

echo -e "${YELLOW}📦 Paso 1: Creando backup...${NC}"
BACKUP_DIR="backup-$(date +%Y%m%d-%H%M%S)"
mkdir -p "../$BACKUP_DIR"
cp -r . "../$BACKUP_DIR/"
echo -e "${GREEN}✓ Backup creado en ../$BACKUP_DIR${NC}"
echo ""

echo -e "${YELLOW}🧹 Paso 2: Limpiando cache y dependencias antiguas...${NC}"
php artisan cache:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
composer clear-cache
rm -rf vendor/
rm -f composer.lock
echo -e "${GREEN}✓ Cache limpiado${NC}"
echo ""

echo -e "${YELLOW}📝 Paso 3: Actualizando composer.json...${NC}"
if [ -f "composer.json.new" ]; then
    cp composer.json composer.json.old
    cp composer.json.new composer.json
    echo -e "${GREEN}✓ composer.json actualizado${NC}"
else
    echo -e "${RED}⚠️  No se encontró composer.json.new${NC}"
fi
echo ""

echo -e "${YELLOW}📥 Paso 4: Instalando dependencias (esto puede tomar varios minutos)...${NC}"
composer install --no-interaction --prefer-dist --optimize-autoloader
echo -e "${GREEN}✓ Dependencias instaladas${NC}"
echo ""

echo -e "${YELLOW}🏗️  Paso 5: Actualizando estructura de archivos...${NC}"

# Backup de archivos que vamos a modificar
echo "  → Haciendo backup de archivos originales..."
[ -f "bootstrap/app.php" ] && cp bootstrap/app.php bootstrap/app.php.old
[ -f "routes/web.php" ] && cp routes/web.php routes/web.php.old
[ -f "app/Http/Kernel.php" ] && cp app/Http/Kernel.php app/Http/Kernel.php.old

# Copiar nuevos archivos si existen
if [ -f "bootstrap_app.php" ]; then
    cp bootstrap_app.php bootstrap/app.php
    echo -e "${GREEN}  ✓ bootstrap/app.php actualizado${NC}"
fi

if [ -f "web.php.new" ]; then
    cp web.php.new routes/web.php
    echo -e "${GREEN}  ✓ routes/web.php actualizado${NC}"
fi

echo ""

echo -e "${YELLOW}🔄 Paso 6: Generando archivos...${NC}"
php artisan key:generate --force
echo -e "${GREEN}✓ Key generada${NC}"
echo ""

echo -e "${YELLOW}🗄️  Paso 7: Migraciones de base de datos...${NC}"
read -p "¿Deseas ejecutar las migraciones? (s/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    php artisan migrate
    echo -e "${GREEN}✓ Migraciones ejecutadas${NC}"
else
    echo -e "${YELLOW}⊘ Migraciones omitidas${NC}"
fi
echo ""

echo -e "${YELLOW}🧪 Paso 8: Optimizando aplicación...${NC}"
php artisan optimize:clear
composer dump-autoload
echo -e "${GREEN}✓ Aplicación optimizada${NC}"
echo ""

echo -e "${GREEN}═══════════════════════════════════════════════${NC}"
echo -e "${GREEN}✨ ¡Migración base completada!${NC}"
echo -e "${GREEN}═══════════════════════════════════════════════${NC}"
echo ""
echo -e "${YELLOW}📋 Tareas pendientes:${NC}"
echo "   1. Revisar y actualizar controladores (eliminar 'use App\Http\Requests')"
echo "   2. Actualizar sintaxis de rutas si no se hizo automáticamente"
echo "   3. Verificar middleware personalizado"
echo "   4. Probar todas las funcionalidades críticas"
echo "   5. Revisar logs en storage/logs/laravel.log"
echo ""
echo -e "${YELLOW}📚 Consulta GUIA_MIGRACION.md para pasos detallados${NC}"
echo ""
echo -e "${GREEN}🎉 ¡Backup disponible en ../$BACKUP_DIR!${NC}"
