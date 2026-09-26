
const menuBtn=document.querySelector('[data-menu]');
const mobile=document.querySelector('[data-mobile]');
if(menuBtn&&mobile){
  menuBtn.addEventListener('click',()=>mobile.classList.toggle('show'));
}
document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{
  const id=a.getAttribute('href');
  if(id && id!="#" && document.querySelector(id)){
    e.preventDefault();
    document.querySelector(id).scrollIntoView({behavior:'smooth'});
    if(mobile) mobile.classList.remove('show');
  }
}));

const form=document.querySelector('[data-form]');
if(form){
  form.addEventListener('submit',e=>{
    e.preventDefault();

    const name=form.querySelector('[name="name"]')?.value.trim() || '';
    const email=form.querySelector('[name="email"]')?.value.trim() || '';
    const business=form.querySelector('[name="business"]')?.value.trim() || '';
    const service=form.querySelector('[name="service"]')?.value.trim() || '';
    const message=form.querySelector('[name="message"]')?.value.trim() || '';

    const text =
`New Project Enquiry
--------------------
Name: ${name}
Email: ${email}
Business/Website: ${business}
Service: ${service}

Message:
${message}`;

    const whatsappUrl='https://wa.me/8801927679203?text='+encodeURIComponent(text);
    window.open(whatsappUrl,'_blank','noopener,noreferrer');

    const btn=form.querySelector('button');
    if(btn){
      const old=btn.textContent;
      btn.textContent='Opening WhatsApp ✓';
      setTimeout(()=>btn.textContent=old,2500);
    }
  });
}
