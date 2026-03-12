/* ═══════════════════════════════════════════
   RAMADAN 1446 H — script.js
   ═══════════════════════════════════════════ */

/* ── STAR CANVAS ──────────────────────────── */
(function initStars() {
  const canvas = document.getElementById('starCanvas');
  const ctx    = canvas.getContext('2d');
  let W, H, stars = [];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  function buildStars(n = 180) {
    stars = Array.from({ length: n }, () => ({
      x:  Math.random() * W,
      y:  Math.random() * H,
      r:  Math.random() * 1.4 + 0.3,
      a:  Math.random(),
      da: (Math.random() * 0.005 + 0.002) * (Math.random() < .5 ? 1 : -1),
    }));
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    stars.forEach(s => {
      s.a = Math.max(0.1, Math.min(1, s.a + s.da));
      if (s.a <= 0.1 || s.a >= 1) s.da *= -1;

      ctx.beginPath();
      ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(217,208,176,${s.a})`;
      ctx.fill();
    });
    requestAnimationFrame(draw);
  }

  window.addEventListener('resize', () => { resize(); buildStars(); });
  resize();
  buildStars();
  draw();
})();


/* ── SCROLL AOS ───────────────────────────── */
(function initAOS() {
  const items = document.querySelectorAll('[data-aos]');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const delay = e.target.dataset.aosDelay || 0;
        setTimeout(() => e.target.classList.add('aos-animate'), +delay);
      }
    });
  }, { threshold: 0.15 });
  items.forEach(el => obs.observe(el));
})();


/* ── COUNTDOWN ────────────────────────────── */
(function initCountdown() {

  const target = new Date('2026-03-20T18:00:00+07:00').getTime();
  const caption = document.getElementById('cdCaption');

  function pad(n){
    return String(n).padStart(2,'0');
  }

  function update(){

    const now = Date.now();
    const diff = target - now;

    if(diff <= 0){
      document.getElementById('cd-d').textContent = "00";
      document.getElementById('cd-h').textContent = "00";
      document.getElementById('cd-m').textContent = "00";
      document.getElementById('cd-s').textContent = "00";

      if(caption) caption.textContent = "Ramadan telah tiba 🌙";
      return;
    }

    const days  = Math.floor(diff / (1000*60*60*24));
    const hours = Math.floor((diff/(1000*60*60)) % 24);
    const mins  = Math.floor((diff/(1000*60)) % 60);
    const secs  = Math.floor((diff/1000) % 60);

    document.getElementById('cd-d').textContent = pad(days);
    document.getElementById('cd-h').textContent = pad(hours);
    document.getElementById('cd-m').textContent = pad(mins);
    document.getElementById('cd-s').textContent = pad(secs);

    setTimeout(update,1000);
  }

  update();

})();

/* ── THR MODAL ────────────────────────────── */
(function initTHR() {
  const modal      = document.getElementById('thrModal');
  const envelope   = document.getElementById('thrEnvelope');
  const amountWrap = document.getElementById('thrAmount');
  const thrValue   = document.getElementById('thrValue');
  const thrBar     = document.getElementById('thrBar');
  const thrPercent = document.getElementById('thrPercent');
  const coinShower = document.getElementById('coinShower');
  const confCanvas = document.getElementById('confettiCanvas');

  // Random THR amounts
  const amounts = [100000, 150000, 200000, 250000, 300000, 500000];
  const emojis  = ['💰','🪙','✨','🌙','⭐','🎁'];

  // ── Confetti ──────────────────────────────
  let confParticles = [];
  let confAnim;
  const COLORS = ['#B5832A','#D4A94E','#D9D0B0','#3E5228','#F2F0E8','#8a5e10'];

  function launchConfetti() {
    const ctx = confCanvas.getContext('2d');
    confCanvas.width  = confCanvas.offsetWidth  || 480;
    confCanvas.height = confCanvas.offsetHeight || 600;

    confParticles = Array.from({ length: 90 }, () => ({
      x:    Math.random() * confCanvas.width,
      y:    -Math.random() * 200,
      w:    Math.random() * 10 + 6,
      h:    Math.random() * 5  + 3,
      color: COLORS[Math.floor(Math.random() * COLORS.length)],
      rot:  Math.random() * 360,
      drot: (Math.random() - .5) * 8,
      vy:   Math.random() * 4  + 2,
      vx:   (Math.random() - .5) * 3,
    }));

    function drawConf() {
      ctx.clearRect(0, 0, confCanvas.width, confCanvas.height);
      let alive = false;
      confParticles.forEach(p => {
        p.y   += p.vy;
        p.x   += p.vx;
        p.rot += p.drot;
        if (p.y < confCanvas.height + 20) alive = true;
        ctx.save();
        ctx.translate(p.x + p.w / 2, p.y + p.h / 2);
        ctx.rotate(p.rot * Math.PI / 180);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
        ctx.restore();
      });
      if (alive) confAnim = requestAnimationFrame(drawConf);
    }
    cancelAnimationFrame(confAnim);
    drawConf();
  }

  // ── Coin shower ───────────────────────────
  function spawnCoins() {
    coinShower.innerHTML = '';
    for (let i = 0; i < 18; i++) {
      const coin = document.createElement('span');
      coin.className = 'coin';
      coin.textContent = emojis[Math.floor(Math.random() * emojis.length)];
      coin.style.cssText = `
        left: ${Math.random() * 100}%;
        animation-duration: ${1.2 + Math.random() * 1.4}s;
        animation-delay: ${Math.random() * 1.2}s;
        font-size: ${1.1 + Math.random()}rem;
      `;
      coinShower.appendChild(coin);
    }
  }

  // ── Envelope click ────────────────────────
  function openEnvelope() {
    if (envelope.classList.contains('opened')) return;
    envelope.classList.add('opened');

    const amount  = amounts[Math.floor(Math.random() * amounts.length)];
    const percent = Math.floor((amount / 500000) * 100);

    // show amount with count-up
    amountWrap.classList.remove('d-none');
    envelope.querySelector('.envelope-hint').textContent = 'Alhamdulillah! 🤲';

    // count-up animation
    let current = 0;
    const step  = amount / 60;
    const fmt   = n => 'Rp ' + Math.floor(n).toLocaleString('id-ID');
    const timer = setInterval(() => {
      current = Math.min(current + step, amount);
      thrValue.textContent = fmt(current);
      if (current >= amount) clearInterval(timer);
    }, 20);

    // progress bar
    setTimeout(() => {
      thrBar.style.width = percent + '%';
      thrPercent.textContent = percent;
    }, 100);

    // confetti + coins
    launchConfetti();
    spawnCoins();
  }

  envelope.addEventListener('click', openEnvelope);

  // ── Reset on modal close ──────────────────
  modal.addEventListener('hidden.bs.modal', () => {
    envelope.classList.remove('opened');
    envelope.querySelector('.envelope-hint').textContent = 'Klik untuk buka amplop';
    amountWrap.classList.add('d-none');
    thrValue.textContent = 'Rp 0';
    thrBar.style.width   = '0%';
    thrPercent.textContent = '0';
    coinShower.innerHTML = '';
    cancelAnimationFrame(confAnim);
    const ctx = confCanvas.getContext('2d');
    ctx.clearRect(0, 0, confCanvas.width, confCanvas.height);
  });

  // ── Trigger confetti when modal SHOWS ─────
  modal.addEventListener('shown.bs.modal', () => {
    spawnCoins();
  });
})();
