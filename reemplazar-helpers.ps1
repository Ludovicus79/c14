# Script para reemplazar helpers Html:: en archivos Blade

$files = Get-ChildItem -Path "resources\views" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Reemplazar Html::style
    $content = $content -replace '\{\!\!\s*Html::style\([''"]([^''"]+)[''"]\)\s*\!\!\}', '<link rel="stylesheet" href="{{ asset(''$1'') }}">'
    
    # Reemplazar Html::script
    $content = $content -replace '\{\!\!\s*Html::script\([''"]([^''"]+)[''"]\)\s*\!\!\}', '<script src="{{ asset(''$1'') }}"></script>'
    
    # Reemplazar Html::link
    $content = $content -replace '\{\!\!\s*Html::link\([''"]([^''"]+)[''"],\s*trans\([''"]([^''"]+)[''"]\)\)\s*\!\!\}', '<a href="{{ url(''$1'') }}">{!! trans(''$2'') !!}</a>'
    
    # Guardar
    Set-Content -Path $file.FullName -Value $content -NoNewline
    
    Write-Host "Actualizado: $($file.Name)" -ForegroundColor Green
}

Write-Host "`nTodos los archivos han sido actualizados." -ForegroundColor Cyan