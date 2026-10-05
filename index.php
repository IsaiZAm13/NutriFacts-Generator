<?php
$dir = __DIR__ . '/etiquetas';
$jsonFile = __DIR__ . '/labels.json';
$products = [];

/* Guardar cambios de un producto */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_product') {
    header('Content-Type: application/json; charset=utf-8');

    $barcodePost = trim((string)($_POST['codigo_barras'] ?? ''));
    $categoriaPost = trim((string)($_POST['categoria'] ?? ''));
    $piezasPost = max(0, (int)($_POST['piezas'] ?? 0));
    $cajasPost = max(0, (int)($_POST['cajas_por_tarima'] ?? 0));

    if ($barcodePost === '') {
        http_response_code(400);
        echo json_encode(['ok' => false, 'message' => 'Código de barras requerido']);
        exit;
    }

    $dataPost = file_exists($jsonFile) ? json_decode((string)file_get_contents($jsonFile), true) : null;

    if (!is_array($dataPost)) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'No se pudo leer labels.json']);
        exit;
    }

    $updated = false;
    foreach ($dataPost as &$productPost) {
        if (!is_array($productPost)) continue;

        if (trim((string)($productPost['codigo_barras'] ?? '')) === $barcodePost) {
            $productPost['categoria'] = $categoriaPost;
            $productPost['piezas'] = $piezasPost;
            $productPost['cajas_por_tarima'] = $cajasPost;
            $updated = true;
            break;
        }
    }
    unset($productPost);

    if (!$updated) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'message' => 'Producto no encontrado']);
        exit;
    }

    $jsonUpdated = json_encode(
        $dataPost,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    if ($jsonUpdated === false || file_put_contents($jsonFile, $jsonUpdated . PHP_EOL, LOCK_EX) === false) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'No se pudo guardar labels.json']);
        exit;
    }

    echo json_encode(['ok' => true, 'message' => 'Producto actualizado correctamente']);
    exit;
}
$iconDir = 'C:/xampp/htdocs/icons';
$iconExtensions = ['png','jpg','jpeg','webp'];

function findProductPdf(string $dir, string $barcode, string $name): string {
    if (!is_dir($dir)) return '';
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if (!$file->isFile() || strtolower($file->getExtension()) !== 'pdf') continue;
        $filename = pathinfo($file->getPathname(), PATHINFO_FILENAME);
        if ($barcode !== '' && preg_match('/(?<!\d)' . preg_quote($barcode, '/') . '(?!\d)/', $filename)) return $file->getPathname();
        if ($name !== '' && mb_stripos($filename, $name, 0, 'UTF-8') !== false) return $file->getPathname();
    }
    return '';
}
function webPath(string $path): string {
    return implode('/', array_map('rawurlencode', explode('/', str_replace('\\','/',$path))));
}
function findIcon(string $barcode, string $jsonIcon = ''): string {
    if ($jsonIcon !== '') {
        return $jsonIcon;
    }

    if ($barcode === '') return '';

    return 'image.php?code=' . rawurlencode($barcode);
}

if (file_exists($jsonFile)) {
    $data = json_decode((string)file_get_contents($jsonFile), true);
    if (is_array($data)) {
        foreach ($data as $item) {
            if (!is_array($item)) continue;
            $name = trim((string)($item['nombre'] ?? ''));
            $barcode = trim((string)($item['codigo_barras'] ?? ''));
            $jsonIcon = trim((string)($item['icono'] ?? ''));
            if ($name === '' && $barcode === '') continue;

            $pdfAbsolute = findProductPdf($dir, $barcode, $name);
            $pdf = '';
            if ($pdfAbsolute !== '') {
                $relative = str_replace('\\','/', substr($pdfAbsolute, strlen(str_replace('\\','/', __DIR__))));
                $pdf = ltrim(webPath($relative), '/');
            }

            $products[] = [
                'nombre' => $name,
                'codigoBarras' => $barcode,
                'icono' => findIcon($barcode, $jsonIcon),
                'categoria' => trim((string)($item['categoria'] ?? '')),
                'piezas' => (int)($item['piezas'] ?? 0),
                'cajasPorTarima' => (int)($item['cajas_por_tarima'] ?? 0),
                'archivo' => $pdfAbsolute ? basename($pdfAbsolute) : '',
                'ruta' => $pdf
            ];
        }
    }
}
usort($products, fn($a,$b) => strcasecmp($a['nombre'],$b['nombre']));
$j = json_encode($products, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>NutriCatalog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="index.php">📦 NutriCatalog</a><div><a class="btn btn-outline-light btn-sm" href="index.php">Catálogo</a> <a class="btn btn-light btn-sm" href="generador.php">Generador</a></div></div></nav>
<main class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4"><div><h3>Catálogo de productos</h3><p class="text-muted mb-0">Productos cargados desde labels.json.</p></div><strong><?=count($products)?> productos</strong></div>
<div class="row g-2 mb-4">
    <div class="col-md-8">
        <div class="input-group">
            <span class="input-group-text">🔎</span>
            <input id="searchInput" class="form-control form-control-lg"
                   placeholder="Buscar producto, código de barras..." autocomplete="off">
        </div>
    </div>
    <div class="col-md-4">
        <select id="categoryFilter" class="form-select form-select-lg">
            <option value="">Todas las categorías</option>
        </select>
    </div>
</div>
<div id="productGrid" class="row g-3"></div>
</main>
<div class="modal fade" id="labelModal" tabindex="-1"><div class="modal-dialog modal-xl modal-dialog-centered" style="max-width:90vw;height:92vh"><div class="modal-content" style="height:92vh"><div class="modal-header"><h5 id="labelModalTitle" class="modal-title"></h5><button class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body p-0"><iframe id="labelFrame" style="width:100%;height:100%;border:0"></iframe></div><div class="modal-footer"><a id="downloadBtn" class="btn btn-outline-secondary" target="_blank">Descargar PDF</a><button id="printBtn" class="btn btn-primary">Imprimir</button></div></div></div></div>
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCodigo" name="codigo_barras">

                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <input type="text" id="editNombre" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="editCategoria" class="form-label">Categoría</label>
                        <input type="text" id="editCategoria" name="categoria" class="form-control"
                               placeholder="Ej. Refrescos, Botanas, Dulces...">
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label for="editPiezas" class="form-label">Piezas</label>
                            <input type="number" id="editPiezas" name="piezas" class="form-control"
                                   min="0" step="1" required>
                        </div>

                        <div class="col-6">
                            <label for="editCajas" class="form-label">Cajas por tarima</label>
                            <input type="number" id="editCajas" name="cajas_por_tarima" class="form-control"
                                   min="0" step="1" required>
                        </div>
                    </div>

                    <div id="editMessage" class="alert d-none mt-3 mb-0"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="saveProductBtn">
                        💾 Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>window.catalogProducts=<?=$j?:'[]'?>;</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const products = window.catalogProducts || [];
const grid = document.getElementById('productGrid');
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');

function loadCategories() {
    const categories = [...new Set(
        products
            .map(p => String(p.categoria || '').trim())
            .filter(Boolean)
    )].sort((a, b) => a.localeCompare(b, 'es'));

    categoryFilter.innerHTML = '<option value="">Todas las categorías</option>' +
        categories.map(category =>
            `<option value="${escapeHtml(category)}">${escapeHtml(category)}</option>`
        ).join('');
}

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;'
    }[char]));
}

function openEdit(index) {
    const p = products[index];
    if (!p) return;

    document.getElementById('editCodigo').value = p.codigoBarras || '';
    document.getElementById('editNombre').value = p.nombre || '';
    document.getElementById('editCategoria').value = p.categoria || '';
    document.getElementById('editPiezas').value = Number(p.piezas || 0);
    document.getElementById('editCajas').value = Number(p.cajasPorTarima || 0);

    const message = document.getElementById('editMessage');
    message.className = 'alert d-none mt-3 mb-0';
    message.textContent = '';

    bootstrap.Modal.getOrCreateInstance(document.getElementById('editModal')).show();
}

document.getElementById('editForm').addEventListener('submit', async (event) => {
    event.preventDefault();

    const button = document.getElementById('saveProductBtn');
    const message = document.getElementById('editMessage');

    button.disabled = true;
    button.textContent = 'Guardando...';

    const formData = new FormData(event.target);
    formData.append('action', 'update_product');

    try {
        const response = await fetch(window.location.href, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (!response.ok || !result.ok) {
            throw new Error(result.message || 'No se pudo actualizar el producto.');
        }

        const barcode = formData.get('codigo_barras');
        const product = products.find(p => String(p.codigoBarras) === String(barcode));

        if (product) {
            product.categoria = formData.get('categoria') || '';
            product.piezas = Number(formData.get('piezas') || 0);
            product.cajasPorTarima = Number(formData.get('cajas_por_tarima') || 0);
        }

        renderProducts(getFilteredProducts());

        message.className = 'alert alert-success mt-3 mb-0';
        message.textContent = 'Producto actualizado correctamente.';

        setTimeout(() => {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editModal')).hide();
        }, 700);

    } catch (error) {
        message.className = 'alert alert-danger mt-3 mb-0';
        message.textContent = error.message;
    } finally {
        button.disabled = false;
        button.textContent = '💾 Guardar cambios';
    }
});

function getFilteredProducts() {
    const term = searchInput.value.trim().toLowerCase();
    const selectedCategory = categoryFilter.value.trim().toLowerCase();

    return products.filter(p => {
        const matchesSearch =
            String(p.nombre || '').toLowerCase().includes(term) ||
            String(p.codigoBarras || '').toLowerCase().includes(term) ||
            String(p.categoria || '').toLowerCase().includes(term);

        const matchesCategory =
            selectedCategory === '' ||
            String(p.categoria || '').trim().toLowerCase() === selectedCategory;

        return matchesSearch && matchesCategory;
    });
}

function renderProducts(list) {
    grid.innerHTML = list.map(p => {
        const categoria = p.categoria || 'Sin categoría';
        const piezas = Number.isFinite(Number(p.piezas)) ? Number(p.piezas) : 0;
        const cajas = Number.isFinite(Number(p.cajasPorTarima)) ? Number(p.cajasPorTarima) : 0;

        return `
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm product-card">
                    <div class="ratio ratio-4x3 bg-light">
                        ${p.icono
                            ? `<img src="${escapeHtml(p.icono)}"
                                    class="card-img-top object-fit-contain p-3"
                                    alt="${escapeHtml(p.nombre)}"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                               <div class="align-items-center justify-content-center text-muted" style="display:none">Sin imagen</div>`
                            : `<div class="d-flex align-items-center justify-content-center text-muted">Sin imagen</div>`
                        }
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">${escapeHtml(p.nombre)}</h5>
                        <div class="small text-muted mb-3">
                            Código: ${escapeHtml(p.codigoBarras)}
                        </div>

                        <div class="mb-3">
                            <span class="badge text-bg-secondary">${escapeHtml(categoria)}</span>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="border rounded p-2 text-center h-100">
                                    <div class="small text-muted">Piezas</div>
                                    <strong>${piezas}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2 text-center h-100">
                                    <div class="small text-muted">Cajas / tarima</div>
                                    <strong>${cajas}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            ${p.ruta
                                ? `<button class="btn btn-primary btn-sm flex-fill"
                                           onclick="openLabelByBarcode('${escapeHtml(p.codigoBarras)}')">Ver etiqueta</button>`
                                : `<button class="btn btn-outline-secondary btn-sm flex-fill" disabled>Sin PDF</button>`
                            }
                            <button class="btn btn-warning btn-sm flex-fill"
                                    onclick="openEditByBarcode('${escapeHtml(p.codigoBarras)}')">✏️ Modificar</button>
                        </div>
                    </div>
                </div>
            </div>`;
    }).join('');
}

function openLabelByBarcode(barcode) {
    const p = products.find(product =>
        String(product.codigoBarras || '') === String(barcode || '')
    );

    if (!p || !p.ruta) return;

    document.getElementById('labelModalTitle').textContent = p.nombre;
    document.getElementById('labelFrame').src = p.ruta;
    document.getElementById('downloadBtn').href = p.ruta;

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('labelModal'));
    modal.show();

    document.getElementById('printBtn').onclick = () => {
        document.getElementById('labelFrame').contentWindow.print();
    };
}

function openEditByBarcode(barcode) {
    const index = products.findIndex(product =>
        String(product.codigoBarras || '') === String(barcode || '')
    );

    if (index !== -1) {
        openEdit(index);
    }
}

searchInput.addEventListener('input', () => {
    renderProducts(getFilteredProducts());
});

categoryFilter.addEventListener('change', () => {
    renderProducts(getFilteredProducts());
});

loadCategories();
renderProducts(products);
</script>
</body></html>
