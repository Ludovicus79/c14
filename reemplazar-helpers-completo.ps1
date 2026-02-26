# Script completo para reemplazar TODOS los helpers de Laravel Collective

$files = Get-ChildItem -Path "resources\views" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $changed = $false
    
    # Html::style
    if ($content -match '\{\!\!\s*Html::style') {
        $content = $content -replace '\{\!\!\s*Html::style\([''"]([^''"]+)[''"]\)\s*\!\!\}', '<link rel="stylesheet" href="{{ asset(''$1'') }}">'
        $changed = $true
    }
    
    # Html::script
    if ($content -match '\{\!\!\s*Html::script') {
        $content = $content -replace '\{\!\!\s*Html::script\([''"]([^''"]+)[''"]\)\s*\!\!\}', '<script src="{{ asset(''$1'') }}"></script>'
        $changed = $true
    }
    
    # Html::link
    if ($content -match '\{\!\!\s*Html::link') {
        $content = $content -replace '\{\!\!\s*Html::link\([''"]([^''"]+)[''"],\s*trans\([''"]([^''"]+)[''"]\)\)\s*\!\!\}', '<a href="{{ url(''$1'') }}">{!! trans(''$2'') !!}</a>'
        $changed = $true
    }
    
    # link_to
    if ($content -match 'link_to\(') {
        Write-Host "ATENCIÓN: $($file.Name) usa link_to() - revisar manualmente" -ForegroundColor Yellow
    }
    
    # Form::
    if ($content -match 'Form::') {
        Write-Host "ATENCIÓN: $($file.Name) usa Form:: - revisar manualmente" -ForegroundColor Yellow
    }
    
    if ($changed) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "✓ Actualizado: $($file.Name)" -ForegroundColor Green
    }
}

Write-Host "`nArchivos actualizados. Revisa los archivos marcados con ATENCIÓN manualmente." -ForegroundColor Cyan