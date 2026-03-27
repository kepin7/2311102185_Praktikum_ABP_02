/* SIMAS utils.js */
const API_BASE = '/api';
const API = {
  get:    e     => $.ajax({url:`${API_BASE}${e}`,method:'GET'}),
  post:   (e,d) => $.ajax({url:`${API_BASE}${e}`,method:'POST',contentType:'application/json',data:JSON.stringify(d)}),
  put:    (e,d) => $.ajax({url:`${API_BASE}${e}`,method:'PUT',contentType:'application/json',data:JSON.stringify(d)}),
  delete: e     => $.ajax({url:`${API_BASE}${e}`,method:'DELETE'})
};

/* ── Toast jQuery plugin ── */
$.fn.siToast = function(msg, type='ok') {
  const cfg = { ok:{icon:'bi-check-circle-fill',cls:'t-ok'}, err:{icon:'bi-x-circle-fill',cls:'t-err'}, warn:{icon:'bi-exclamation-triangle-fill',cls:'t-warn'} };
  const c = cfg[type]||cfg.ok;
  const $t=$(`<div class="toast-item ${c.cls}"><div class="toast-icon"><i class="bi ${c.icon}"></i></div><span class="toast-text">${msg}</span><span class="toast-x"><i class="bi bi-x"></i></span></div>`);
  $('.toasts').append($t);
  $t.find('.toast-x').on('click',()=>dismiss($t));
  setTimeout(()=>dismiss($t),3500);
  function dismiss($el){$el.css('animation','tOut 0.3s var(--ease) forwards');setTimeout(()=>$el.remove(),300);}
  return this;
};

/* ── Validate jQuery plugin ── */
$.fn.siValidate = function() {
  let ok=true;
  $(this).find('[data-req]').each(function(){
    const $e=$(this),$f=$e.siblings('.field-err');
    if(!$e.val().trim()){$e.addClass('err').removeClass('ok');$f.addClass('show');ok=false;}
    else{$e.removeClass('err').addClass('ok');$f.removeClass('show');}
  });
  return ok;
};
$.fn.siReset = function(){
  $(this).find('.field-input').removeClass('err ok');
  $(this).find('.field-err').removeClass('show');
  return this;
};

/* ── Live validation on blur ── */
$(document).on('blur','.field-input[data-req]',function(){
  const $e=$(this),$f=$e.siblings('.field-err');
  if(!$e.val().trim()){$e.addClass('err').removeClass('ok');$f.addClass('show');}
  else{$e.removeClass('err').addClass('ok');$f.removeClass('show');}
});

/* ── Active nav ── */
$(document).ready(function(){
  const p=window.location.pathname;
  $('.nav-link').each(function(){
    const h=$(this).attr('href');
    if(h&&(p===h||(h!=='/'&&p.startsWith(h))))$(this).addClass('active');
  });
});

/* ── Data ── */
const FAKULTAS_PRODI = [
  {fak:'Fakultas Informatika (FIF)',prodi:['S1 Informatika (Teknik Informatika)','S1 Rekayasa Perangkat Lunak','S1 Sains Data','S1 Sistem Informasi']},
  {fak:'Fakultas Teknik Elektro (FTTE)',prodi:['S1 Teknik Telekomunikasi','S1 Teknik Elektro','S1 Teknik Biomedis']},
  {fak:'Fakultas Rekayasa Industri (FRI)',prodi:['S1 Teknik Industri','S1 Teknik Logistik','S1 Teknologi Pangan']},
  {fak:'Fakultas Industri Kreatif (FIK)',prodi:['S1 Desain Komunikasi Visual (DKV)','S1 Desain Produk & Inovasi']},
  {fak:'Fakultas Ekonomi dan Bisnis (FEB)',prodi:['S1 Bisnis Digital']},
  {fak:'Fakultas Ilmu Terapan (FIT)',prodi:['D3 Teknik Telekomunikasi']}
];
const PRODI_LIST = FAKULTAS_PRODI.flatMap(f=>f.prodi);

function buildProdiOptions($s,sel=''){
  $s.empty().append('<option value="">— Pilih Program Studi —</option>');
  FAKULTAS_PRODI.forEach(f=>{
    const $g=$(`<optgroup label="${f.fak}"></optgroup>`);
    f.prodi.forEach(p=>$g.append(`<option value="${p}"${p===sel?' selected':''}>${p}</option>`));
    $s.append($g);
  });
}
function buildAngkatanOptions($s,sel=''){
  const y=new Date().getFullYear();
  $s.empty().append('<option value="">— Pilih Angkatan —</option>');
  for(let i=y;i>=1990;i--)$s.append(`<option value="${i}"${String(i)===String(sel)?' selected':''}>${i}</option>`);
}

/* ── Helpers ── */
function statusBadge(s){const m={Aktif:'aktif',Cuti:'cuti',Lulus:'lulus'};return`<span class="badge badge-${m[s]||'aktif'}">${s}</span>`;}
function ipkBar(v){const p=(v/4)*100;return`<div class="ipk-w"><span class="ipk-n">${parseFloat(v).toFixed(2)}</span><div class="ipk-track"><div class="ipk-fill" style="width:${p}%"></div></div></div>`;}
function nimBadge(n){return`<span class="nim">${n}</span>`;}
function getFakultas(prodi){for(const f of FAKULTAS_PRODI){if(f.prodi.includes(prodi)){const m=f.fak.match(/\(([^)]+)\)/);return m?m[1]:f.fak;}}return'Lainnya';}
