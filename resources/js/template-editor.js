/**
 * Template Inline Editor
 * Only loaded in edit mode (?edit-template=1 + authenticated user)
 */

// ─── State ───────────────────────────────────────────────────────────
let currentKeyword = '';
let currentContentEl = null;

// ─── Build Modal ─────────────────────────────────────────────────────

function createEditorModal() {
    const modal = document.createElement('div');
    modal.id = 'tplEditorModal';
    modal.className = 'tpl-modal-overlay';
    modal.innerHTML = `
        <div class="tpl-modal-container">
            <div class="tpl-modal-header">
                <div class="tpl-modal-header-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    <h3>Edit Template</h3>
                </div>
                <button type="button" id="tplEditorClose" class="tpl-modal-close-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="tpl-modal-body">
                <label class="tpl-label">
                    <span class="tpl-label-text">Keyword</span>
                    <input type="text" id="tplEditorKeyword" class="tpl-input" readonly />
                </label>
                <label class="tpl-label">
                    <span class="tpl-label-text">Content</span>
                    <textarea id="tplEditorContent" class="tpl-textarea" rows="8"></textarea>
                </label>
            </div>
            <div class="tpl-modal-footer">
                <button type="button" id="tplEditorCancel" class="tpl-btn tpl-btn-cancel">Batal</button>
                <button type="button" id="tplEditorSave" class="tpl-btn tpl-btn-save">
                    <span id="tplSaveBtnText">Simpan</span>
                    <span id="tplSaveBtnLoading" class="tpl-hidden">Menyimpan...</span>
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Event listeners
    document.getElementById('tplEditorClose').addEventListener('click', closeEditor);
    document.getElementById('tplEditorCancel').addEventListener('click', closeEditor);
    document.getElementById('tplEditorSave').addEventListener('click', saveTemplate);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeEditor();
    });
}

// ─── Open / Close ────────────────────────────────────────────────────

function openEditor(keyword, content, contentEl) {
    currentKeyword = keyword;
    currentContentEl = contentEl;

    const modal = document.getElementById('tplEditorModal');
    document.getElementById('tplEditorKeyword').value = keyword;
    document.getElementById('tplEditorContent').value = content;

    modal.classList.add('tpl-modal-visible');
    document.body.style.overflow = 'hidden';

    // Focus textarea
    setTimeout(() => {
        document.getElementById('tplEditorContent').focus();
    }, 100);
}

function closeEditor() {
    const modal = document.getElementById('tplEditorModal');
    modal.classList.remove('tpl-modal-visible');
    document.body.style.overflow = '';
    currentKeyword = '';
    currentContentEl = null;
}

// ─── Save ────────────────────────────────────────────────────────────

async function saveTemplate() {
    const keyword = document.getElementById('tplEditorKeyword').value;
    const content = document.getElementById('tplEditorContent').value;
    const saveBtn = document.getElementById('tplEditorSave');
    const saveBtnText = document.getElementById('tplSaveBtnText');
    const saveBtnLoading = document.getElementById('tplSaveBtnLoading');

    // Loading state
    saveBtn.disabled = true;
    saveBtnText.classList.add('tpl-hidden');
    saveBtnLoading.classList.remove('tpl-hidden');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    try {
        const response = await fetch('/jt-admin/api/template/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ keyword, content }),
        });

        const data = await response.json();

        if (data.success) {
            // Update DOM content
            if (currentContentEl) {
                currentContentEl.innerHTML = data.content;
            }

            // Also update the data-content attribute on the edit button
            const editBtn = currentContentEl?.parentElement?.querySelector('.tpl-edit-btn');
            if (editBtn) {
                editBtn.setAttribute('data-content', data.content);
            }

            closeEditor();
            showToast('Template berhasil diperbarui!', 'success');
        } else {
            showToast(data.message || 'Gagal menyimpan template.', 'error');
        }
    } catch (error) {
        console.error('Save error:', error);
        showToast('Gagal menyimpan template. Cek koneksi.', 'error');
    } finally {
        saveBtn.disabled = false;
        saveBtnText.classList.remove('tpl-hidden');
        saveBtnLoading.classList.add('tpl-hidden');
    }
}

// ─── Toast ───────────────────────────────────────────────────────────

function showToast(message, type = 'success') {
    const existing = document.querySelector('.tpl-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = `tpl-toast tpl-toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.add('tpl-toast-visible');
    });

    setTimeout(() => {
        toast.classList.remove('tpl-toast-visible');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ─── Init ────────────────────────────────────────────────────────────

function init() {
    createEditorModal();

    // Attach click handlers to all edit buttons
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.tpl-edit-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const keyword = btn.getAttribute('data-keyword');
        const content = btn.getAttribute('data-content');
        const contentEl = btn.parentElement.querySelector('.tpl-content');

        openEditor(keyword, content, contentEl);
    });

    // ESC to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modal = document.getElementById('tplEditorModal');
            if (modal && modal.classList.contains('tpl-modal-visible')) {
                closeEditor();
            }
        }
    });

    // Add edit-mode indicator bar
    const bar = document.createElement('div');
    bar.className = 'tpl-edit-bar';
    bar.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        <span>MODE EDIT TEMPLATE — Klik ikon <strong>✏️</strong> pada konten untuk mengedit</span>
        <a href="${window.location.pathname}" class="tpl-edit-bar-close">Keluar Edit Mode</a>
    `;
    document.body.prepend(bar);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
