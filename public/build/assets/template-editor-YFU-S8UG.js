let l=null;function u(){const t=document.createElement("div");t.id="tplEditorModal",t.className="tpl-modal-overlay",t.innerHTML=`
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
    `,document.body.appendChild(t),document.getElementById("tplEditorClose").addEventListener("click",a),document.getElementById("tplEditorCancel").addEventListener("click",a),document.getElementById("tplEditorSave").addEventListener("click",E),t.addEventListener("click",n=>{n.target===t&&a()})}function v(t,n,e){l=e;const o=document.getElementById("tplEditorModal");document.getElementById("tplEditorKeyword").value=t,document.getElementById("tplEditorContent").value=n,o.classList.add("tpl-modal-visible"),document.body.style.overflow="hidden",setTimeout(()=>{document.getElementById("tplEditorContent").focus()},100)}function a(){document.getElementById("tplEditorModal").classList.remove("tpl-modal-visible"),document.body.style.overflow="",l=null}async function E(){const t=document.getElementById("tplEditorKeyword").value,n=document.getElementById("tplEditorContent").value,e=document.getElementById("tplEditorSave"),o=document.getElementById("tplSaveBtnText"),d=document.getElementById("tplSaveBtnLoading");e.disabled=!0,o.classList.add("tpl-hidden"),d.classList.remove("tpl-hidden");const i=document.querySelector('meta[name="csrf-token"]')?.content||"";try{const s=await(await fetch("/jt-admin/api/template/update",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":i,Accept:"application/json"},body:JSON.stringify({keyword:t,content:n})})).json();if(s.success){l&&(l.innerHTML=s.content);const p=l?.parentElement?.querySelector(".tpl-edit-btn");p&&p.setAttribute("data-content",s.content),a(),r("Template berhasil diperbarui!","success")}else r(s.message||"Gagal menyimpan template.","error")}catch(c){console.error("Save error:",c),r("Gagal menyimpan template. Cek koneksi.","error")}finally{e.disabled=!1,o.classList.remove("tpl-hidden"),d.classList.add("tpl-hidden")}}function r(t,n="success"){const e=document.querySelector(".tpl-toast");e&&e.remove();const o=document.createElement("div");o.className=`tpl-toast tpl-toast-${n}`,o.textContent=t,document.body.appendChild(o),requestAnimationFrame(()=>{o.classList.add("tpl-toast-visible")}),setTimeout(()=>{o.classList.remove("tpl-toast-visible"),setTimeout(()=>o.remove(),300)},3e3)}function m(){u(),document.addEventListener("click",n=>{const e=n.target.closest(".tpl-edit-btn");if(!e)return;n.preventDefault(),n.stopPropagation();const o=e.getAttribute("data-keyword"),d=e.getAttribute("data-content"),i=e.parentElement.querySelector(".tpl-content");v(o,d,i)}),document.addEventListener("keydown",n=>{if(n.key==="Escape"){const e=document.getElementById("tplEditorModal");e&&e.classList.contains("tpl-modal-visible")&&a()}});const t=document.createElement("div");t.className="tpl-edit-bar",t.innerHTML=`
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        <span>MODE EDIT TEMPLATE — Klik ikon <strong>✏️</strong> pada konten untuk mengedit</span>
        <a href="${window.location.pathname}" class="tpl-edit-bar-close">Keluar Edit Mode</a>
    `,document.body.prepend(t)}document.readyState==="loading"?document.addEventListener("DOMContentLoaded",m):m();
