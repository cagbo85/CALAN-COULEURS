import{r as i,j as e,c as v}from"./client-8xLAL1SS.js";/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y=t=>t.replace(/([a-z0-9])([A-Z])/g,"$1-$2").toLowerCase(),N=t=>t.replace(/^([A-Z])|[\s-_]+(\w)/g,(s,r,o)=>o?o.toUpperCase():r.toLowerCase()),b=t=>{const s=N(t);return s.charAt(0).toUpperCase()+s.slice(1)},g=(...t)=>t.filter((s,r,o)=>!!s&&s.trim()!==""&&o.indexOf(s)===r).join(" ").trim();/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */var C={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor",strokeWidth:2,strokeLinecap:"round",strokeLinejoin:"round"};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q=i.forwardRef(({color:t="currentColor",size:s=24,strokeWidth:r=2,absoluteStrokeWidth:o,className:l="",children:a,iconNode:m,...u},c)=>i.createElement("svg",{ref:c,...C,width:s,height:s,stroke:t,strokeWidth:o?Number(r)*24/Number(s):r,className:g("lucide",l),...u},[...m.map(([x,d])=>i.createElement(x,d)),...Array.isArray(a)?a:[a]]));/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w=(t,s)=>{const r=i.forwardRef(({className:o,...l},a)=>i.createElement(q,{ref:a,iconNode:s,className:g(`lucide-${y(b(t))}`,`lucide-${t}`,o),...l}));return r.displayName=b(t),r};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A=[["path",{d:"m6 9 6 6 6-6",key:"qrunsl"}]],k=w("chevron-down",A);/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E=[["path",{d:"m18 15-6-6-6 6",key:"153udz"}]],$=w("chevron-up",E);function F({idBase:t,buttonId:s,panelId:r,question:o,answer:l}){const[a,m]=i.useState(!1),u=()=>m(c=>!c);return e.jsxs("div",{className:"bg-white/10 backdrop-blur-md rounded-md text-white px-4 py-3","data-open":a?"true":"false",children:[e.jsx("h3",{className:"m-0",children:e.jsxs("button",{id:s,type:"button",onClick:u,"aria-expanded":a,"aria-controls":r,className:"w-full flex justify-between items-center font-semibold uppercase text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#8F1E98] rounded-md py-1",children:[e.jsx("span",{children:o}),e.jsx("span",{"aria-hidden":"true",className:"ml-2",children:a?e.jsx($,{size:18,"aria-hidden":"true",focusable:"false"}):e.jsx(k,{size:18,"aria-hidden":"true",focusable:"false"})})]})}),e.jsx("div",{id:r,role:"region","aria-labelledby":s,hidden:!a,className:"mt-2 text-sm text-white/80",children:e.jsx("p",{children:l})})]})}function I(){const[t,s]=i.useState([]),[r,o]=i.useState(!0),[l,a]=i.useState(null),m="faq",u=`${m}-heading`,c=`${m}-desc`,x=`${m}-error`;return i.useEffect(()=>{const d=new AbortController;async function p(){try{const n=await fetch("/api/faqs",{signal:d.signal});if(!n.ok)throw new Error(`HTTP ${n.status}`);const h=await n.json();s(Array.isArray(h)?h:[]),a(null)}catch(n){console.error("Erreur lors du chargement des FAQs:",n),a("Impossible de charger la FAQ pour le moment."),s([{id:"fallback-1",question:"Où et quand se déroule le festival ?",answer:"Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de musique."},{id:"fallback-2",question:"À quelle heure ouvrent les portes ?",answer:"Nous vous accueillons dès 19h le vendredi et 13h le samedi."}])}finally{o(!1)}}return p(),()=>d.abort()},[]),r?e.jsx("section",{className:"py-16 px-6",style:{background:"linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)"},"aria-labelledby":u,"aria-describedby":c,"aria-busy":"true",role:"region",children:e.jsxs("div",{className:"container mx-auto",children:[e.jsx("h2",{id:u,className:"text-white text-3xl font-bold uppercase mb-2",children:"Foire aux questions"}),e.jsx("p",{id:c,className:"sr-only",children:"Questions les plus fréquentes au sujet du festival Calan’Couleurs."}),e.jsx("div",{className:"max-w-2xl mx-auto mt-8 text-white text-center",role:"status","aria-live":"polite",children:"Chargement des FAQs…"})]})}):e.jsx("section",{className:"py-16 px-6",style:{background:"linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)"},"aria-labelledby":u,"aria-describedby":l?`${c} ${x}`:c,role:"region",children:e.jsxs("div",{className:"container mx-auto",children:[e.jsx("h2",{id:u,className:"text-white text-3xl font-bold uppercase mb-2",children:"Foire aux questions"}),e.jsx("p",{id:c,className:"sr-only",children:"Questions fréquentes et réponses pratiques pour préparer votre venue."}),l&&e.jsx("div",{id:x,className:"max-w-2xl mx-auto mt-4 text-white bg-red-600/30 border border-red-500/50 rounded p-3",role:"alert","aria-live":"assertive",children:l}),e.jsx("div",{className:"max-w-2xl mx-auto mt-6 space-y-4",children:t.length>0?e.jsx("ul",{role:"list","aria-label":"Liste des questions fréquentes",children:t.map((d,p)=>{const n=typeof d.id<"u"?d.id:`faq-${p}`,h=`${n}-button`,j=`${n}-panel`;return e.jsx("li",{role:"listitem",className:"mb-3",children:e.jsx(F,{idBase:n,buttonId:h,panelId:j,question:d.question,answer:d.answer})},n)})}):e.jsx("p",{className:"text-white/90",role:"note",children:"Aucune question pour le moment."})})]})})}const f=document.getElementById("faq-root");f&&v.createRoot(f).render(e.jsx(I,{}));
