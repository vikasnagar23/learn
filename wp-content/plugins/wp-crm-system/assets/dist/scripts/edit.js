function editField(e){var n,t=document.getElementById(e+"-input"),l=document.getElementById(e+"-text"),d=document.getElementById(e+"-label");null!==document.getElementById(e+"-comment")&&(n=document.getElementById(e+"-comment")),"none"==t.style.display?(t.style.display="inline",l.style.display="none",null!==document.getElementById(e+"-comment")&&(n.style.display="inline")):(t.style.display="none",l.style.display="inline",null!==document.getElementById(e+"-comment")&&(n.style.display="none")),"none"==d.style.display?d.style.display="inline":d.style.display="none"}function showEdit(e){var n=document.getElementById(e+"-edit");"none"==n.style.display?n.style.display="inline":n.style.display="none"}function hideEdit(e){var n=document.getElementById(e+"-edit");"inline"==n.style.display?n.style.display="none":n.style.display="inline"}