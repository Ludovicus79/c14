# NAPROC 13 - Base de Datos de Carbono 13

## ✅ ERRORES CORREGIDOS

### 1. **Controladores de Autenticación Faltantes**
Se han creado todos los controladores necesarios en `app/Http/Controllers/Auth/`:
- ✅ `RegisterController.php` - Con validación de reCAPTCHA
- ✅ `LoginController.php` - Con autenticación por 'login' en lugar de 'email'
- ✅ `ForgotPasswordController.php`
- ✅ `ResetPasswordController.php`
- ✅ `ConfirmPasswordController.php`
- ✅ `VerificationController.php`

### 2. **Sistema reCAPTCHA Implementado**
- ✅ Validación de reCAPTCHA v2 en el registro de usuarios
- ✅ Script de reCAPTCHA añadido al layout principal
- ✅ Widget de reCAPTCHA integrado en el formulario de registro
- ✅ Configuración en `config/services.php`

### 3. **Modelo User Actualizado**
- ✅ Añadidos campos faltantes: `login`, `university`, `city`, `country`, `is_admin`
- ✅ Campos protegidos en el array `$fillable`

### 4. **Corrección en Vista de Login**
- ✅ Campo de login corregido (antes usaba 'email', ahora usa 'login')
- ✅ Consistencia con el LoginController

---

## 🚀 INSTRUCCIONES DE INSTALACIÓN

### 1. Configuración del archivo .env

Copia el archivo `.env.example` a `.env`:
```bash
cp .env.example .env
```

### 2. ⚠️ IMPORTANTE: Regenera tus claves reCAPTCHA

**NUNCA uses las claves que compartiste públicamente**. Debes generar nuevas claves:

1. Ve a: https://www.google.com/recaptcha/admin
2. Crea un nuevo sitio con reCAPTCHA v2 ("No soy un robot")
3. Añade tus dominios (localhost para desarrollo)
4. Copia las nuevas claves al archivo `.env`:

```env
RECAPTCHA_SITE_KEY=tu_nueva_clave_del_sitio
RECAPTCHA_SECRET_KEY=tu_nueva_clave_secreta
```

### 3. Genera la clave de aplicación

```bash
php artisan key:generate
```

### 4. Configura la base de datos

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Ejecuta las migraciones

```bash
php artisan migrate
```

### 6. Instala las dependencias (si es necesario)

```bash
composer install
npm install && npm run dev
```

### 7. Limpia la caché

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Inicia el servidor de desarrollo

```bash
php artisan serve
```

---

## 📁 ARCHIVOS MODIFICADOS/CREADOS

### Nuevos Controladores (app/Http/Controllers/Auth/)
- `RegisterController.php` ⭐ Con reCAPTCHA
- `LoginController.php`
- `ForgotPasswordController.php`
- `ResetPasswordController.php`
- `ConfirmPasswordController.php`
- `VerificationController.php`

### Archivos Modificados
- `app/User.php` - Añadidos campos al fillable
- `config/services.php` - Añadida configuración de reCAPTCHA
- `resources/views/auth/register.blade.php` - Añadido widget reCAPTCHA
- `resources/views/auth/login.blade.php` - Corregido campo de login
- `resources/views/layouts/master.blade.php` - Añadido script reCAPTCHA

### Nuevos Archivos de Configuración
- `.env.example` - Plantilla de configuración

---

## 🔒 SEGURIDAD

### Variables de Entorno Sensibles

Las siguientes variables **NUNCA** deben ser compartidas públicamente:
- `APP_KEY`
- `DB_PASSWORD`
- `RECAPTCHA_SECRET_KEY`
- Cualquier API key o secreto

Asegúrate de que el archivo `.env` esté en tu `.gitignore`:
```
.env
.env.backup
```

---

## 🧪 PRUEBAS

### Probar el Registro con reCAPTCHA

1. Ve a: http://localhost:8000/register
2. Completa el formulario
3. Marca la casilla "No soy un robot"
4. Envía el formulario

Si el reCAPTCHA falla, verás el mensaje:
> "La verificación reCAPTCHA ha fallado. Por favor, inténtalo de nuevo."

### Probar el Login

1. Ve a: http://localhost:8000/login
2. Usa el campo 'login' (no email) para autenticarte
3. Introduce tu contraseña
4. Click en "Iniciar Sesión"

---

## 📝 NOTAS ADICIONALES

### Campos del Usuario

El formulario de registro incluye:
- **login** (obligatorio, único)
- **name** (obligatorio)
- **email** (obligatorio, único)
- **password** (obligatorio, mínimo 8 caracteres)
- **password_confirmation** (obligatorio)
- **university** (opcional)
- **city** (opcional)
- **country** (opcional)

### Autenticación

La aplicación usa **'login'** como campo de autenticación, no 'email'. Esto está configurado en el `LoginController`.

### reCAPTCHA

La implementación usa **reCAPTCHA v2** ("No soy un robot"). Si prefieres reCAPTCHA v3 (invisible), necesitarás modificar:
1. El tipo de sitio en Google reCAPTCHA Admin
2. El código en `RegisterController.php`
3. El widget en `register.blade.php`

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### Error: "Class RegisterController not found"
```bash
composer dump-autoload
php artisan config:clear
php artisan route:clear
```

### Error: reCAPTCHA no se muestra
- Verifica que el script esté cargado en el layout
- Revisa la consola del navegador para errores JavaScript
- Asegúrate de que las claves en `.env` sean correctas

### Error: "CSRF token mismatch"
```bash
php artisan cache:clear
php artisan config:clear
```

### Error al hacer login con email
- El sistema usa 'login', no 'email' para autenticación
- Asegúrate de usar el campo 'login' del usuario

---

## 📞 SOPORTE

Si tienes más problemas, asegúrate de:
1. Revisar los logs de Laravel en `storage/logs/laravel.log`
2. Verificar que todas las dependencias estén instaladas
3. Comprobar que la base de datos esté correctamente configurada
4. Revisar que las claves de reCAPTCHA sean válidas y correspondan a tu dominio

---

## ✨ CARACTERÍSTICAS IMPLEMENTADAS

- ✅ Sistema completo de autenticación Laravel
- ✅ Registro de usuarios con validación avanzada
- ✅ reCAPTCHA v2 para prevenir bots
- ✅ Login con campo 'login' personalizado
- ✅ Validación de contraseñas seguras (mínimo 8 caracteres)
- ✅ Validación de campos únicos (login y email)
- ✅ Mensajes de error personalizados en español
- ✅ Campos opcionales para datos de usuario extendidos

---


