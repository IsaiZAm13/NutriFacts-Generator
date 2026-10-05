
<!doctype html>
<html
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Generador de Nutrition Facts — 62.5 × 152.5 mm</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="css/styles.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<style>
/* ===== Ajuste de tipografía para aprovechar mejor el área de la etiqueta ===== */
#labelInner {
    font-size: 16px;
}

#labelInner .nf-title {
    font-size: 34px !important;
    line-height: 1.02;
    margin-bottom: 3px;
}

#labelInner .servings {
    font-size: 15px !important;
    line-height: 1.05;
    margin-bottom: 3px;
}

#labelInner .serving {
    font-size: 18px !important;
    line-height: 1.05;
}

#labelInner .amount {
    font-size: 16px !important;
    line-height: 1.05;
}

#labelInner .calrow {
    line-height: 1;
}

#labelInner .calories {
    font-size: 29px !important;
    font-weight: 800;
}

#labelInner .calnum {
    font-size: 39px !important;
    font-weight: 900;
}

#labelInner .dvhead {
    font-size: 14px !important;
    line-height: 1.05;
}

#labelInner .nutrient {
    font-size: 17px !important;
    line-height: 1.12;
    min-height: 20px;
}

#labelInner .nutrient .amt,
#labelInner .nutrient .dv {
    font-size: 17px !important;
}

#labelInner .vitamins {
    font-size: 16px !important;
    line-height: 1.15;
}

#labelInner .vitem {
    font-size: 16px !important;
}

#labelInner .foot {
    font-size: 12px !important;
    line-height: 1.15;
}

#labelInner .ingredients,
#labelInner .contains {
    font-size: 15px !important;
    line-height: 1.18;
}

/* Más aprovechamiento horizontal */
#labelInner .indent {
    padding-left: 12px;
}

#labelInner .indent2 {
    padding-left: 24px;
}
</style>

</head>
<body>
<nav class="navbar navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="index.php">📦 NutriCatalog</a><div><a class="btn btn-outline-light btn-sm" href="index.php">Catálogo</a> <a class="btn btn-light btn-sm" href="generador.php">Generador</a></div></div></nav>

<div class="app">
<section class="panel">
<h1>Generador de Nutrition Facts</h1>
<p class="note">Etiqueta basada en el formato Nutrition Facts de la FDA. Tamaño físico: <b>62.5 × 152.5 pulgadas</b>. Se deja un <b>margen de seguridad interno de 0.08 in</b> para tolerancias de impresión y corte.</p>

<h2>Datos del producto</h2>
<div class="grid">
<div class="field"><label>Nombre del producto</label><input id="labelName" value="Prueba" maxlength="120"></div>
<div class="field"><label>Código de barras</label><input id="barcode" value="001" maxlength="64"></div>
</div>

<h2>Encabezado</h2>
<div class="grid">
<div class="field"><label>Porciones por envase</label><input id="servings" value="4"></div>
<div class="field"><label>Tamaño de porción</label><input id="servSize" value="355 ml"></div>
</div>

<h2>Energía</h2>
<div class="grid">
<div class="field"><label>Calorías</label><input id="calories" value="130"></div>
</div>

<h2>Grasas y colesterol</h2>
<div class="grid">
<div class="field"><label>Grasa total (g)</label><input id="fat" value="0"></div>
<div class="field"><label>% VD</label><input id="fatDv" value="0"></div>
<div class="field"><label>Grasa saturada (g)</label><input id="sat" value="1"></div>
<div class="field"><label>% VD</label><input id="satDv" value="5"></div>
<div class="field"><label>Grasa trans (g)</label><input id="trans" value="0"></div>
<div class="field"><label>Colesterol (mg)</label><input id="chol" value="0"></div>
<div class="field"><label>% VD colesterol</label><input id="cholDv" value="0"></div>
</div>

<h2>Sodio y carbohidratos</h2>
<div class="grid">
<div class="field"><label>Sodio (mg)</label><input id="sodium" value="10"></div>
<div class="field"><label>% VD</label><input id="sodiumDv" value="0"></div>
<div class="field"><label>Carbohidratos (g)</label><input id="carbs" value="34"></div>
<div class="field"><label>% VD</label><input id="carbsDv" value="13"></div>
<div class="field"><label>Fibra dietética (g)</label><input id="fiber" value="4"></div>
<div class="field"><label>% VD</label><input id="fiberDv" value="14"></div>
<div class="field"><label>Azúcares totales (g)</label><input id="sugars" value="33"></div>
<div class="field"><label>Azúcares añadidos (g)</label><input id="added" value="10"></div>
<div class="field"><label>% VD azúcares añadidos</label><input id="addedDv" value="20"></div>
<div class="field"><label>Proteína (g)</label><input id="protein" value="3"></div>
</div>

<h2>Vitaminas y minerales</h2>
<div class="grid">
<div class="field"><label>Vitamina D (mcg)</label><input id="vitd" value="2"></div>
<div class="field"><label>% VD</label><input id="vitdDv" value="10"></div>
<div class="field"><label>Calcio (mg)</label><input id="calcium" value="260"></div>
<div class="field"><label>% VD</label><input id="calciumDv" value="20"></div>
<div class="field"><label>Hierro (mg)</label><input id="iron" value="8"></div>
<div class="field"><label>% VD</label><input id="ironDv" value="45"></div>
<div class="field"><label>Potasio (mg)</label><input id="potassium" value="240"></div>
<div class="field"><label>% VD</label><input id="potassiumDv" value="6"></div>
</div>

<h2>Ingredientes y alérgenos</h2>
<div class="grid">
<div class="field full"><label>Ingredientes</label><textarea id="ingredients">Leche parcialmente descremada de vaca (5,0% de 30g de grasa butírica y 6,4% de proteínas de la leche) y azúcares añadidos (azúcar), pasteurizados.</textarea></div>
<div class="field full"><label>Contiene</label><input id="contains" value="Leche."></div>
</div>

<div id="downloadStatus" class="note" style="display:none;margin-top:10px"></div>
  <div class="actions">
<button type="button" onclick="downloadPNG()">Descargar PNG</button>
<button type="button" onclick="downloadPDFNamed()">Descargar PDF con nombre</button>
<button type="button" onclick="saveLabelToProject()">Guardar etiqueta en proyecto</button>
<button type="button" onclick="downloadPDF()">Descargar PDF</button>
<button type="button" class="secondary" onclick="window.print()">Imprimir 62.5 × 152.5</button>
<button type="button" class="secondary" onclick="resetForm()">Restablecer ejemplo</button>
</div>
<p class="note" style="margin-top:12px"><b>Formato:</b> se aplican las especificaciones gráficas de referencia de FDA (jerarquía tipográfica, reglas y espaciado). Verifica siempre los valores nutricionales y los requisitos aplicables a tu producto antes de imprimir.</p>
<p class="note" style="margin-top:12px">El PDF/impresión está configurado a 62.5 × 152.5 mm. Al imprimir, desactiva “Ajustar a página” o “Fit to page”.</p>
</section>

<section class="preview-area">
<div class="preview-title">Vista previa</div>
<div class="zoom">Zoom <input id="zoom" type="range" min="150" max="500" value="300" oninput="setZoom(this.value)"></div>
<div class="zoom">Margen seguro: <b>0.08 in</b> por lado</div>
<div id="label">
<div id="labelInner">
<div class="nf-title">Nutrition Facts</div>
<div class="servings"><span id="pServings">4</span> servings per container</div>
<div class="serving"><span>Serving size</span><span id="pServSize">355 ml</span></div>
<div class="bar thick"></div>
<div class="amount">Amount per serving</div>
<div class="calrow"><span class="calories">Calories</span><span class="calnum" id="pCalories">130</span></div>
<div class="dvhead">% Daily Value*</div>

<div class="nutrient bold"><span class="name">Total Fat <span class="amt" id="pFat">0g</span></span><span class="dv" id="pFatDv">0%</span></div>
<div class="nutrient indent"><span class="name">Saturated Fat <span class="amt" id="pSat">1g</span></span><span class="dv" id="pSatDv">5%</span></div>
<div class="nutrient indent"><span class="name"><i>Trans</i> Fat <span class="amt" id="pTrans">0g</span></span></div>
<div class="nutrient bold"><span class="name">Cholesterol <span class="amt" id="pChol">0mg</span></span><span class="dv" id="pCholDv">0%</span></div>
<div class="nutrient bold"><span class="name">Sodium <span class="amt" id="pSodium">10mg</span></span><span class="dv" id="pSodiumDv">0%</span></div>
<div class="nutrient bold"><span class="name">Total Carbohydrate <span class="amt" id="pCarbs">34g</span></span><span class="dv" id="pCarbsDv">13%</span></div>
<div class="nutrient indent"><span class="name">Dietary Fiber <span class="amt" id="pFiber">4g</span></span><span class="dv" id="pFiberDv">14%</span></div>
<div class="nutrient indent"><span class="name">Total Sugars <span class="amt" id="pSugars">33g</span></span></div>
<div class="nutrient indent2"><span class="name">Includes <span id="pAdded">10g</span> Added Sugars</span><span class="dv" id="pAddedDv">20%</span></div>
<div class="nutrient bold"><span class="name">Protein <span class="amt" id="pProtein">3g</span></span></div>

<div class="vitamins">
<div class="vitem"><span>Vit. D <span id="pVitd">2mcg</span></span><b id="pVitdDv">10%</b></div>
<div class="vitem"><span>Calcium <span id="pCalcium">260mg</span></span><b id="pCalciumDv">20%</b></div>
<div class="vitem"><span>Iron <span id="pIron">8mg</span></span><b id="pIronDv">45%</b></div>
<div class="vitem"><span>Potas. <span id="pPotassium">240mg</span></span><b id="pPotassiumDv">6%</b></div>
</div>

<div class="foot">* The % Daily Value (DV) tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</div>
<div class="ingredients"><b>Ingredients:</b> <span id="pIngredients"></span></div>
<div class="contains">Contains: <span id="pContains"></span></div>
</div>
</div>
</section>
</div>

<script>
const ids = [
'servings','servSize','calories','fat','fatDv','sat','satDv','trans','chol','cholDv',
'sodium','sodiumDv','carbs','carbsDv','fiber','fiberDv','sugars','added','addedDv','protein',
'vitd','vitdDv','calcium','calciumDv','iron','ironDv','potassium','potassiumDv','ingredients','contains'
];
const map = {
servings:'pServings',servSize:'pServSize',calories:'pCalories',fat:'pFat',fatDv:'pFatDv',
sat:'pSat',satDv:'pSatDv',trans:'pTrans',chol:'pChol',cholDv:'pCholDv',sodium:'pSodium',
sodiumDv:'pSodiumDv',carbs:'pCarbs',carbsDv:'pCarbsDv',fiber:'pFiber',fiberDv:'pFiberDv',
sugars:'pSugars',added:'pAdded',addedDv:'pAddedDv',protein:'pProtein',vitd:'pVitd',
vitdDv:'pVitdDv',calcium:'pCalcium',calciumDv:'pCalciumDv',iron:'pIron',ironDv:'pIronDv',
potassium:'pPotassium',potassiumDv:'pPotassiumDv',ingredients:'pIngredients',contains:'pContains'
};
function val(id){return document.getElementById(id).value.trim()}
function update(){
  ids.forEach(id=>{
    const el=document.getElementById(map[id]);
    let v=val(id);
    if(['fat','sat','trans','fiber','sugars','added','protein'].includes(id)) v += 'g';
    if(['chol','sodium','calcium','iron','potassium'].includes(id)) v += 'mg';
    if(id==='vitd') v += 'mcg';
    if(id.endsWith('Dv')) v += '%';
    el.textContent=v;
  });
}
ids.forEach(id=>document.getElementById(id).addEventListener('input',update));
update();

function setZoom(v){
  const label=document.getElementById('label');
  label.style.width=(2.460629921260*v/300)+'in';
  label.style.height=(6.003937007874*v/300)+'in';
}
function resetForm(){location.reload()}

function svgString(){
  const label = document.getElementById('label');
  const clone = label.cloneNode(true);

  // Export at 600 x 900 px = 62.5 x 152.5 in at 300 DPI.
  clone.removeAttribute('id');
  clone.style.width = '738px';
  clone.style.height = '1801px';
  clone.style.border = '0';
  clone.style.margin = '0';

  const styles = [...document.styleSheets].map(s=>{
    try{
      return [...s.cssRules].map(r=>r.cssText).join('');
    }catch(e){ return ''; }
  }).join('');

  return `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xhtml="http://www.w3.org/1999/xhtml"
     width="738" height="1801" viewBox="0 0 738 1801">
  <defs>
    <style><![CDATA[${styles}]]></style>
  </defs>
  <rect width="738" height="1801" fill="#fff"/>
  <foreignObject x="0" y="0" width="738" height="1801">
    <div xmlns="http://www.w3.org/1999/xhtml"
         style="width:738px;height:1801px;background:#fff;overflow:hidden;">
      ${clone.outerHTML}
    </div>
  </foreignObject>
</svg>`;
}

function forceDownload(blob, filename){
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = filename;
  a.rel = 'noopener';
  a.style.display = 'none';
  document.body.appendChild(a);

  a.click();

  const status = document.getElementById('downloadStatus');
  if(status){
    status.style.display='block';
    status.textContent='Archivo generado: ' + filename;
  }

  setTimeout(()=>{
    a.remove();
    URL.revokeObjectURL(url);
  }, 3000);
}

function downloadPNG(){
  const svg = svgString();
  const blob = new Blob([svg], {type:'image/svg+xml;charset=utf-8'});
  const url = URL.createObjectURL(blob);
  const img = new Image();

  img.onload = ()=>{
    try{
      const c = document.createElement('canvas');
      c.width = 1476;
      c.height = 3602;
      const ctx = c.getContext('2d', {willReadFrequently:false});
      ctx.fillStyle = '#fff';
      ctx.fillRect(0,0,c.width,c.height);
      ctx.drawImage(img,0,0,1476,3602);

      c.toBlob(pngBlob=>{
        URL.revokeObjectURL(url);
        if(!pngBlob){
          alert('No fue posible crear el PNG en este navegador.');
          return;
        }
        forceDownload(pngBlob,'nutrition-facts-62.5x152.5mm.png');
      },'image/png');
    }catch(err){
      URL.revokeObjectURL(url);
      console.error(err);
      alert('No fue posible crear el PNG. Prueba Chrome o Edge actualizado.');
    }
  };

  img.onerror = ()=>{
    URL.revokeObjectURL(url);
    alert('No fue posible procesar la etiqueta para PNG.');
  };

  img.src = url;
}

async function downloadPDF(){
  /*
    Generador PDF nativo: no depende de jsPDF ni de CDN externos.
    Crea un PDF 62.5 x 152.5 pulgadas directamente a partir del canvas.
  */
  try{
    const svg = svgString();
    const svgBlob = new Blob([svg], {type:'image/svg+xml;charset=utf-8'});
    const svgUrl = URL.createObjectURL(svgBlob);
    const img = new Image();

    img.onload = async ()=>{
      try{
        const c = document.createElement('canvas');
        c.width = 600;
        c.height = 900;

        const ctx = c.getContext('2d', {willReadFrequently:true});
        ctx.fillStyle = '#fff';
        ctx.fillRect(0,0,c.width,c.height);
        ctx.drawImage(img,0,0,600,900);
        URL.revokeObjectURL(svgUrl);

        const image = ctx.getImageData(0,0,600,900);
        const rgb = new Uint8Array(600*900*3);

        // PDF image data: RGB, sin canal alfa.
        let j=0;
        for(let i=0;i<image.data.length;i+=4){
          rgb[j++] = image.data[i];
          rgb[j++] = image.data[i+1];
          rgb[j++] = image.data[i+2];
        }

        let streamData = rgb;
        let filter = '';

        // Comprimir si el navegador soporta CompressionStream.
        if(typeof CompressionStream !== 'undefined'){
          try{
            const cs = new CompressionStream('deflate');
            const compressed = await new Response(
              new Blob([rgb]).stream().pipeThrough(cs)
            ).arrayBuffer();
            streamData = new Uint8Array(compressed);
            filter = '/Filter /FlateDecode ';
          }catch(e){
            console.warn('No se pudo comprimir el PDF; se usará RGB sin comprimir.',e);
          }
        }

        // PDF de 62.5 x 152.5 pulgadas = 144 x 216 puntos.
        const pageW = 177.165354330709;
        const pageH = 432.283464566929;

        const objects = [];
        objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        objects[2] = '<< /Type /Pages /Kids [3 0 R] /Count 1 >>';
        objects[3] =
          '<< /Type /Page /Parent 2 0 R ' +
          '/MediaBox [0 0 177.165354 432.283465] ' +
          '/Resources << /XObject << /Im 4 0 R >> >> ' +
          '/Contents 5 0 R >>';

        objects[4] =
          `<< /Type /XObject /Subtype /Image /Width 738 /Height 1801 ` +
          `/ColorSpace /DeviceRGB /BitsPerComponent 8 ${filter}/Length ${streamData.length} >>`;

        const content = `q\n${pageW} 0 0 ${pageH} 0 0 cm\n/Im Do\nQ\n`;
        const contentBytes = new TextEncoder().encode(content);
        objects[5] = `<< /Length ${contentBytes.length} >>`;

        const chunks = [];
        const offsets = [0];
        let position = 0;

        function addText(text){
          const bytes = new TextEncoder().encode(text);
          chunks.push(bytes);
          position += bytes.length;
        }
        function addBytes(bytes){
          chunks.push(bytes);
          position += bytes.length;
        }

        addText('%PDF-1.4\n%\xFF\xFF\xFF\xFF\n');

        for(let n=1;n<=5;n++){
          offsets[n]=position;
          addText(`${n} 0 obj\n`);
          addText(objects[n]);
          addText('\n');

          if(n===4){
            addText('stream\n');
            addBytes(streamData);
            addText('\nendstream\n');
          }else if(n===5){
            addText('stream\n');
            addBytes(contentBytes);
            addText('endstream\n');
          }

          addText('endobj\n');
        }

        const xrefOffset = position;
        addText('xref\n0 6\n');
        addText('0000000000 65535 f \n');

        for(let n=1;n<=5;n++){
          addText(String(offsets[n]).padStart(10,'0') + ' 00000 n \n');
        }

        addText(
          'trailer\n' +
          '<< /Size 6 /Root 1 0 R >>\n' +
          'startxref\n' +
          String(xrefOffset) +
          '\n%%EOF'
        );

        const pdfBlob = new Blob(chunks,{type:'application/pdf'});
        forceDownload(pdfBlob,'nutrition-facts-62.5x152.5mm.pdf');

      }catch(err){
        URL.revokeObjectURL(svgUrl);
        console.error(err);
        alert('No fue posible crear el PDF: ' + (err.message || err));
      }
    };

    img.onerror = ()=>{
      URL.revokeObjectURL(svgUrl);
      alert('No fue posible procesar la etiqueta para PDF.');
    };

    img.src = svgUrl;

  }catch(err){
    console.error(err);
    alert('Error al generar el PDF: ' + (err.message || err));
  }
}



// ===== Funciones adicionales: nombre, código, JSON y guardado en proyecto =====
function getProductName(){
  return (document.getElementById('labelName')?.value || 'nutrition-facts').trim();
}
function getBarcode(){
  return (document.getElementById('barcode')?.value || '').trim();
}
function safeFileName(name){
  return name.replace(/[\\/:*?"<>|]+/g,'_').replace(/\s+/g,' ').trim() || 'nutrition-facts';
}

function canvasToPdfBlob(canvas){
  return new Promise((resolve,reject)=>{
    try{
      const dataUrl=canvas.toDataURL('image/jpeg',0.95);
      const b64=dataUrl.split(',')[1];
      const bin=atob(b64);
      const imgBytes=new Uint8Array(bin.length);
      for(let i=0;i<bin.length;i++) imgBytes[i]=bin.charCodeAt(i);

      const enc=new TextEncoder();
      const parts=[];
      const offsets=[0];
      let pos=0;
      const push=s=>{const b=typeof s==='string'?enc.encode(s):s; parts.push(b); pos+=b.length;};
      const obj=(n,body)=>{offsets[n]=pos; push(n+' 0 obj\n'); push(body); push('\nendobj\n');};

      push('%PDF-1.4\n%\xFF\xFF\xFF\xFF\n');
      obj(1,'<< /Type /Catalog /Pages 2 0 R >>');
      obj(2,'<< /Type /Pages /Kids [3 0 R] /Count 1 >>');
      obj(3,'<< /Type /Page /Parent 2 0 R /MediaBox [0 0 177.165354 432.283465] /Resources << /XObject << /Im0 5 0 R >> >> /Contents 4 0 R >>');
      const content='q\n177.165354 0 0 432.283465 0 0 cm\n/Im0 Do\nQ\n';
      obj(4,'<< /Length '+enc.encode(content).length+' >>\nstream\n'+content+'endstream');
      offsets[5]=pos;
      push('5 0 obj\n<< /Type /XObject /Subtype /Image /Width '+canvas.width+' /Height '+canvas.height+' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length '+imgBytes.length+' >>\nstream\n');
      push(imgBytes); push('\nendstream\nendobj\n');
      const xref=pos; push('xref\n0 6\n0000000000 65535 f \n');
      for(let i=1;i<=5;i++) push(String(offsets[i]).padStart(10,'0')+' 00000 n \n');
      push('trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n'+xref+'\n%%EOF');
      resolve(new Blob(parts,{type:'application/pdf'}));
    }catch(e){reject(e)}
  });
}

async function renderLabelWithoutForeignObject(){
  if(typeof html2canvas==='undefined') throw new Error('No se pudo cargar html2canvas. Verifica la conexión a Internet.');
  const label=document.getElementById('label');
  const rect=label.getBoundingClientRect();
  const targetW=738, targetH=1801;
  const canvas=await html2canvas(label,{
    backgroundColor:'#fff',
    scale:targetW/rect.width,
    width:rect.width,
    height:rect.height,
    useCORS:true,
    allowTaint:false,
    logging:false
  });
  // Garantiza exactamente 738x1801 para el PDF 62.5x152.5 mm.
  if(canvas.width!==targetW || canvas.height!==targetH){
    const c=document.createElement('canvas'); c.width=targetW; c.height=targetH;
    c.getContext('2d').drawImage(canvas,0,0,targetW,targetH); return c;
  }
  return canvas;
}

async function createNamedPdf(){
  const canvas=await renderLabelWithoutForeignObject();
  return await canvasToPdfBlob(canvas);
}

async function downloadPDFNamed(){
  try{
    const name=safeFileName(getProductName());
    const blob=await createNamedPdf();
    forceDownload(blob,name+'.pdf');
  }catch(err){
    console.error(err);
    alert('No fue posible crear el PDF: '+(err.message||err));
  }
}

async function saveLabelToProject(){
  try{
    const name=getProductName();
    const barcode=getBarcode();
    if(!name){alert('Escribe el nombre del producto.');return;}
    if(!barcode){alert('Escribe el código de barras.');return;}
    const blob=await createNamedPdf();
    const fd=new FormData();
    fd.append('pdf',blob,safeFileName(name)+'.pdf');
    fd.append('nombre',name);
    fd.append('codigo_barras',barcode);
    const res=await fetch('save_label.php',{method:'POST',body:fd});
    const data=await res.json();
    if(!res.ok || !data.ok) throw new Error(data.message||'Error del servidor');
    alert('Etiqueta guardada correctamente en la carpeta etiquetas/.');
  }catch(err){
    console.error(err);
    alert('No fue posible guardar la etiqueta: '+(err.message||err));
  }
}

</script>
</body>
</html>
