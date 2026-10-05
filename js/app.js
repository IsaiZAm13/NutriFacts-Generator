(function(){
 const products=Array.isArray(window.catalogProducts)?window.catalogProducts:[];
 const grid=document.getElementById('productGrid'), search=document.getElementById('searchInput');
 function render(list){
  grid.innerHTML='';
  if(!list.length){grid.innerHTML='<div class="col-12"><div class="alert alert-secondary">No se encontraron productos.</div></div>';return;}
  list.forEach(p=>{
   const col=document.createElement('div'); col.className='col-12 col-sm-6 col-lg-4 col-xl-3';
   const card=document.createElement('div'); card.className='card h-100 shadow-sm product-card';
   const media=document.createElement('div'); media.className='product-image';
   if(p.icono){const img=document.createElement('img');img.src=p.icono;img.alt=p.nombre||'Producto';img.loading='lazy';img.onerror=function(){media.innerHTML='<div class="image-missing">Imagen no encontrada</div>';};media.appendChild(img);}
   else media.innerHTML='<div class="image-missing">Sin imagen</div>';
   const body=document.createElement('div');body.className='card-body d-flex flex-column';
   const h=document.createElement('h5');h.className='card-title';h.textContent=p.nombre||'Sin nombre';body.appendChild(h);
   if(p.codigoBarras){const small=document.createElement('div');small.className='text-muted small mb-3';small.textContent='Código: '+p.codigoBarras;body.appendChild(small);}
   const btn=document.createElement('button');btn.className='btn btn-primary mt-auto';btn.textContent=p.ruta?'Ver etiqueta':'Sin PDF';btn.disabled=!p.ruta;
   btn.onclick=()=>openPdf(p);body.appendChild(btn);card.append(media,body);col.appendChild(card);grid.appendChild(col);
  });
 }
 function openPdf(p){
  const frame=document.getElementById('labelFrame'); const title=document.getElementById('labelModalTitle'); const dl=document.getElementById('downloadBtn');
  const url=p.ruta; frame.src=url; title.textContent=p.nombre||'Etiqueta'; dl.href=url;
  new bootstrap.Modal(document.getElementById('labelModal')).show();
  document.getElementById('printBtn').onclick=()=>{try{frame.contentWindow.print();}catch(e){window.open(url,'_blank');}};
 }
 search.addEventListener('input',()=>{const q=search.value.toLowerCase().trim();render(products.filter(p=>(p.nombre||'').toLowerCase().includes(q)||(p.codigoBarras||'').toLowerCase().includes(q)));});
 render(products);
})();
