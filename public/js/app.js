/* ═══════════════════════════════════════════
   AI TOOLS HUB — MAIN JS
   by Yozee
═══════════════════════════════════════════ */

// ── Mock Data ─────────────────────────────

const CATEGORIES = [
  { id: 'all',        label: 'All Tools',      emoji: '✦' },
  { id: 'writing',    label: 'Writing',         emoji: '✍️' },
  { id: 'image',      label: 'Image',           emoji: '🎨' },
  { id: 'video',      label: 'Video',           emoji: '🎬' },
  { id: 'code',       label: 'Code',            emoji: '💻' },
  { id: 'audio',      label: 'Audio',           emoji: '🎵' },
  { id: 'productivity',label: 'Productivity',   emoji: '⚡' },
  { id: 'business',   label: 'Business',        emoji: '📊' },
  { id: 'research',   label: 'Research',        emoji: '🔬' },
];

const TOOLS = [
  { id:1,  name:'ChatGPT',     emoji:'🤖', category:'writing',     desc:'The world\'s most popular AI assistant. Great for writing, answering questions, brainstorming, and coding.', url:'https://chat.openai.com', rating:4.8, votes:2841, reviews:312, trending:true,  new:false },
  { id:2,  name:'Midjourney',  emoji:'🎨', category:'image',       desc:'Create stunning AI-generated artwork and images with a simple text prompt inside Discord.', url:'https://midjourney.com', rating:4.9, votes:1923, reviews:245, trending:true,  new:false },
  { id:3,  name:'Claude',      emoji:'🧠', category:'writing',     desc:'Anthropic\'s AI assistant — known for thoughtful, nuanced responses and excellent long-form writing.', url:'https://claude.ai', rating:4.8, votes:1654, reviews:198, trending:true,  new:false },
  { id:4,  name:'GitHub Copilot', emoji:'👨‍💻', category:'code',  desc:'AI pair programmer that suggests code completions, functions, and entire algorithms as you type.', url:'https://github.com/features/copilot', rating:4.7, votes:1432, reviews:187, trending:false, new:false },
  { id:5,  name:'Runway ML',   emoji:'🎬', category:'video',       desc:'Professional AI video generation and editing. Create stunning video content from text prompts.', url:'https://runwayml.com', rating:4.6, votes:987,  reviews:134, trending:false, new:true  },
  { id:6,  name:'ElevenLabs',  emoji:'🎙️', category:'audio',      desc:'Hyper-realistic AI voice synthesis and cloning. Create natural-sounding voiceovers in seconds.', url:'https://elevenlabs.io', rating:4.7, votes:876,  reviews:112, trending:false, new:true  },
  { id:7,  name:'Notion AI',   emoji:'📝', category:'productivity',desc:'AI built into Notion. Summarize notes, draft content, and improve your writing inside your workspace.', url:'https://notion.so/ai', rating:4.5, votes:765,  reviews:98,  trending:false, new:false },
  { id:8,  name:'Perplexity',  emoji:'🔍', category:'research',    desc:'AI-powered search engine that gives direct, cited answers instead of just links.', url:'https://perplexity.ai', rating:4.7, votes:1123, reviews:156, trending:true,  new:false },
  { id:9,  name:'DALL-E 3',    emoji:'🖼️', category:'image',      desc:'OpenAI\'s image generation model. Create detailed, photorealistic or artistic images from text.', url:'https://openai.com/dall-e-3', rating:4.6, votes:892,  reviews:123, trending:false, new:false },
  { id:10, name:'Cursor',      emoji:'⌨️', category:'code',       desc:'AI-first code editor built on VS Code. Chat with your codebase and generate code with full context.', url:'https://cursor.sh', rating:4.8, votes:743,  reviews:89,  trending:false, new:true  },
  { id:11, name:'Suno AI',     emoji:'🎶', category:'audio',       desc:'Generate full songs with vocals, instruments, and lyrics from a text prompt in seconds.', url:'https://suno.ai', rating:4.5, votes:654,  reviews:78,  trending:false, new:true  },
  { id:12, name:'Gemini',      emoji:'✨', category:'writing',     desc:'Google\'s most capable AI model. Excellent for multimodal tasks including image understanding.', url:'https://gemini.google.com', rating:4.5, votes:891,  reviews:143, trending:false, new:false },
];

const REVIEWS = [
  { user:'Amina K.', initial:'A', rating:5, body:'ChatGPT has completely changed how I write. I use it every day for work. Highly recommend!', date:'2 days ago' },
  { user:'David M.', initial:'D', rating:4, body:'Really powerful tool. Sometimes the responses can be a bit generic but overall excellent value.', date:'1 week ago' },
  { user:'Fatuma R.', initial:'F', rating:5, body:'As a student this is absolutely incredible. My assignments have never been better written.', date:'2 weeks ago' },
];

// ── App State ─────────────────────────────

const State = {
  currentCategory: 'all',
  searchQuery: '',
  savedTools: new Set([1, 3]),  // pre-saved for demo
  currentUser: null,  // null = guest
  activeModal: null,
  starRating: 0,
};

// ── Utilities ─────────────────────────────

function filterTools() {
  return TOOLS.filter(t => {
    const matchCat = State.currentCategory === 'all' || t.category === State.currentCategory;
    const q = State.searchQuery.toLowerCase();
    const matchSearch = !q || t.name.toLowerCase().includes(q) || t.desc.toLowerCase().includes(q);
    return matchCat && matchSearch;
  });
}

function renderStars(rating) {
  const full = Math.floor(rating);
  const half = rating % 1 >= 0.5;
  let html = '';
  for (let i = 0; i < full; i++) html += '★';
  if (half) html += '½';
  return html;
}

function showToast(message, type = 'info') {
  const container = document.getElementById('toast-container');
  const icons = { success: '✓', error: '✕', info: 'ℹ' };
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `<span>${icons[type]}</span><span>${message}</span>`;
  container.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

function openModal(id) {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
  const modal = document.getElementById(`modal-${id}`);
  if (modal) modal.classList.add('active');
  State.activeModal = id;
}

function closeModal(id) {
  const modal = document.getElementById(`modal-${id}`);
  if (modal) modal.classList.remove('active');
  State.activeModal = null;
}

// Close modal on overlay click
document.addEventListener('click', e => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('active');
    State.activeModal = null;
  }
});

// ── Navbar & Search ───────────────────────

function initSearch() {
  const input = document.getElementById('nav-search-input');
  if (!input) return;
  input.addEventListener('input', e => {
    State.searchQuery = e.target.value;
    renderToolsGrid();
    renderResultCount();
  });
}

function renderResultCount() {
  const el = document.getElementById('results-count');
  if (!el) return;
  const count = filterTools().length;
  el.textContent = `${count} tool${count !== 1 ? 's' : ''}`;
}

// ── Category Tabs ─────────────────────────

function renderCategoryTabs() {
  const container = document.getElementById('category-tabs');
  if (!container) return;
  container.innerHTML = CATEGORIES.map(cat => `
    <button class="cat-tab ${cat.id === State.currentCategory ? 'active' : ''}"
            onclick="selectCategory('${cat.id}')">
      <span class="cat-tab-emoji">${cat.emoji}</span>
      ${cat.label}
    </button>
  `).join('');
}

function selectCategory(id) {
  State.currentCategory = id;
  renderCategoryTabs();
  renderToolsGrid();
  renderResultCount();
}

// ── Tool Cards ────────────────────────────

function renderToolCard(tool) {
  const saved = State.savedTools.has(tool.id);
  return `
    <div class="tool-card fade-in-up" onclick="openToolDetail(${tool.id})">
      ${tool.trending ? '<div class="tool-trending-badge">Trending</div>' : ''}
      <div class="tool-card-top">
        <div class="tool-icon">${tool.emoji}</div>
        <div class="tool-actions">
          ${tool.new ? '<span style="background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);font-size:10px;font-weight:700;padding:3px 8px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase">New</span>' : ''}
          <button class="tool-action-btn ${saved ? 'saved' : ''}" title="${saved ? 'Saved' : 'Save'}"
                  onclick="toggleSave(event, ${tool.id})">
            ${saved ? '♥' : '♡'}
          </button>
          <button class="tool-action-btn" title="Open tool"
                  onclick="openTool(event, '${tool.url}')">↗</button>
        </div>
      </div>
      <div>
        <div class="tool-name">${tool.name}</div>
      </div>
      <div class="tool-desc">${tool.desc}</div>
      <div class="tool-card-footer">
        <div class="tool-cat-badge">
          ${CATEGORIES.find(c=>c.id===tool.category)?.emoji || ''}
          ${tool.category}
        </div>
        <div class="tool-rating">
          <span class="tool-rating-stars">★</span>
          <span class="tool-rating-num">${tool.rating}</span>
          <span class="tool-rating-count">(${tool.votes.toLocaleString()})</span>
        </div>
      </div>
    </div>
  `;
}

function renderToolsGrid() {
  const grid = document.getElementById('tools-grid');
  if (!grid) return;
  const tools = filterTools();
  if (tools.length === 0) {
    grid.innerHTML = `
      <div class="empty-state" style="grid-column:1/-1">
        <div class="empty-icon">🔍</div>
        <div class="empty-title">No tools found</div>
        <div class="empty-sub">Try a different search or category</div>
      </div>`;
    return;
  }
  grid.innerHTML = tools.map(renderToolCard).join('');
}

// ── Trending Row ──────────────────────────

function renderTrending() {
  const container = document.getElementById('trending-row');
  if (!container) return;
  const trending = TOOLS.filter(t => t.trending).slice(0, 5);
  container.innerHTML = trending.map((t, i) => `
    <div class="trending-card" onclick="openToolDetail(${t.id})">
      <div class="trending-rank ${i < 3 ? 'top' : ''}">#${i+1}</div>
      <div class="trending-info">
        <div class="trending-name">${t.name}</div>
        <div class="trending-meta">${t.votes.toLocaleString()} upvotes</div>
      </div>
      <div class="trending-icon">${t.emoji}</div>
    </div>
  `).join('');
}

// ── Save / Favorites ──────────────────────

function toggleSave(e, toolId) {
  e.stopPropagation();
  if (!State.currentUser) {
    openModal('login');
    showToast('Sign in to save tools', 'info');
    return;
  }
  if (State.savedTools.has(toolId)) {
    State.savedTools.delete(toolId);
    showToast('Removed from favorites', 'info');
  } else {
    State.savedTools.add(toolId);
    showToast('Saved to favorites ♥', 'success');
  }
  renderToolsGrid();
}

function openTool(e, url) {
  e.stopPropagation();
  window.open(url, '_blank', 'noopener');
}

// ── Tool Detail ───────────────────────────

function openToolDetail(toolId) {
  const tool = TOOLS.find(t => t.id === toolId);
  if (!tool) return;

  const overlay = document.getElementById('modal-tool-detail');
  overlay.innerHTML = `
    <div class="modal" style="max-width:700px;max-height:90vh;overflow-y:auto;">
      <div style="display:flex;align-items:flex-start;gap:20px;margin-bottom:24px;">
        <div style="width:72px;height:72px;border-radius:18px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:34px;flex-shrink:0">${tool.emoji}</div>
        <div style="flex:1">
          <div style="font-family:var(--font-display);font-size:28px;font-weight:800;margin-bottom:6px">${tool.name}</div>
          <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
            <span class="tool-cat-badge">${CATEGORIES.find(c=>c.id===tool.category)?.emoji} ${tool.category}</span>
            <span style="color:var(--amber);font-size:14px">★ ${tool.rating}</span>
            <span style="font-size:13px;color:var(--text3)">${tool.votes.toLocaleString()} upvotes · ${tool.reviews} reviews</span>
            ${tool.new ? '<span style="background:var(--accent)20;border:1px solid var(--accent)40;color:var(--accent);font-size:10px;font-weight:700;padding:3px 8px;border-radius:100px">NEW</span>' : ''}
          </div>
        </div>
        <button onclick="closeModal('tool-detail')" style="background:var(--surface2);border:1px solid var(--border);color:var(--text2);width:36px;height:36px;border-radius:8px;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;flex-shrink:0">✕</button>
      </div>

      <p style="font-size:15px;color:var(--text2);line-height:1.6;margin-bottom:24px">${tool.desc}</p>

      <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:28px">
        <a href="${tool.url}" target="_blank" rel="noopener" class="btn btn-primary">Visit ${tool.name} ↗</a>
        <button class="btn btn-outline" onclick="toggleSave(event,${tool.id})">${State.savedTools.has(tool.id) ? '♥ Saved' : '♡ Save'}</button>
        <button class="btn btn-outline" onclick="${State.currentUser ? "openModal('ask-yozee')" : "openModal('login')" }">Ask Yozee</button>
      </div>

      <div style="border-top:1px solid var(--border);padding-top:24px;margin-bottom:20px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
          <div style="font-family:var(--font-display);font-size:16px;font-weight:700">Community Reviews</div>
          <button class="btn btn-sm btn-outline" onclick="${State.currentUser ? 'openModal("write-review")' : 'openModal("login")'}">Write a review</button>
        </div>
        ${REVIEWS.map(r => `
          <div class="review-card">
            <div class="review-header">
              <div class="review-user">
                <div class="review-avatar">${r.initial}</div>
                <div>
                  <div class="review-name">${r.user}</div>
                  <div class="review-date">${r.date}</div>
                </div>
              </div>
              <div style="color:var(--amber);font-size:13px">${'★'.repeat(r.rating)}</div>
            </div>
            <div class="review-body">${r.body}</div>
          </div>
        `).join('')}
      </div>

      ${!State.currentUser ? `
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center">
          <div style="font-size:14px;color:var(--text2);margin-bottom:10px">Sign in to rate, save, and write reviews</div>
          <button class="btn btn-primary btn-sm" onclick="closeModal('tool-detail');openModal('login')">Sign in free</button>
        </div>
      ` : ''}
    </div>
  `;
  openModal('tool-detail');
}

// ── Auth ──────────────────────────────────

function handleLogin(e) {
  e.preventDefault();
  const email = document.getElementById('login-email').value;
  const pass  = document.getElementById('login-pass').value;
  if (!email || !pass) { showToast('Please fill all fields', 'error'); return; }

  // Demo login
  State.currentUser = { name: 'Yozee User', email, role: 'user' };
  closeModal('login');
  updateAuthUI();
  showToast('Welcome back! 👋', 'success');
}

function handleRegister(e) {
  e.preventDefault();
  const name  = document.getElementById('reg-name').value;
  const email = document.getElementById('reg-email').value;
  const pass  = document.getElementById('reg-pass').value;
  if (!name || !email || !pass) { showToast('Please fill all fields', 'error'); return; }

  State.currentUser = { name, email, role: 'user' };
  closeModal('register');
  updateAuthUI();
  showToast(`Welcome, ${name}! 🎉`, 'success');
}

function handleLogout() {
  State.currentUser = null;
  updateAuthUI();
  showToast('Logged out successfully', 'info');
}

function updateAuthUI() {
  const authButtons = document.getElementById('auth-buttons');
  const userMenu    = document.getElementById('user-menu');

  if (State.currentUser) {
    authButtons && (authButtons.style.display = 'none');
    if (userMenu) {
      userMenu.style.display = 'flex';
      const nameEl = document.getElementById('user-name');
      if (nameEl) nameEl.textContent = State.currentUser.name;
    }
  } else {
    authButtons && (authButtons.style.display = 'flex');
    userMenu && (userMenu.style.display = 'none');
  }
  renderToolsGrid();
}

// ── Suggest Tool ──────────────────────────

function handleSuggest(e) {
  e.preventDefault();
  if (!State.currentUser) { openModal('login'); return; }
  const name = document.getElementById('suggest-name')?.value;
  const url  = document.getElementById('suggest-url')?.value;
  if (!name || !url) { showToast('Please fill all fields', 'error'); return; }
  closeModal('suggest');
  showToast('Tool submitted for review! We\'ll notify you when it\'s approved.', 'success');
  document.getElementById('suggest-form')?.reset();
}

// ── Ask Yozee ─────────────────────────────

function handleAskYozee(e) {
  e.preventDefault();
  const msg = document.getElementById('ask-message')?.value;
  if (!msg) { showToast('Please write your question', 'error'); return; }
  closeModal('ask-yozee');
  showToast('Question sent to Yozee! You\'ll get a reply soon.', 'success');
  document.getElementById('ask-form')?.reset();
}

// ── Star Rating ───────────────────────────

function setStarRating(n) {
  State.starRating = n;
  document.querySelectorAll('.star-btn').forEach((btn, i) => {
    btn.classList.toggle('active', i < n);
  });
}

// ── Admin Actions ─────────────────────────

function deleteToolAdmin(id) {
  if (confirm('Delete this tool?')) {
    showToast('Tool deleted', 'success');
  }
}

function approveItem(id, type) {
  showToast(`${type} approved ✓`, 'success');
}

function rejectItem(id, type) {
  showToast(`${type} rejected`, 'info');
}

// ── PWA Install ───────────────────────────

let deferredPrompt;
window.addEventListener('beforeinstallprompt', e => {
  e.preventDefault();
  deferredPrompt = e;
  const installBtn = document.getElementById('install-btn');
  if (installBtn) installBtn.style.display = 'flex';
});

function installPWA() {
  if (deferredPrompt) {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(result => {
      if (result.outcome === 'accepted') showToast('App installed! ✓', 'success');
      deferredPrompt = null;
    });
  }
}

// ── Init ──────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  renderCategoryTabs();
  renderToolsGrid();
  renderTrending();
  renderResultCount();
  initSearch();
  updateAuthUI();
});
