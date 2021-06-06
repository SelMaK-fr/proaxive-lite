/********
01. Textarea autoExpand
02. Nav Mobile Submenu
03. Link Table Target
04. Print contenair ID
05. Notifications
06. Toggle card
07. Scroll Breadcrumbs
********/

/******************
 * 01. Textarea autoExpand
 ******************/
var autoExpand = function (field) {

	// Reset field height
	field.style.height = 'inherit';

	// Get the computed styles for the element
	var computed = window.getComputedStyle(field);

	// Calculate the height
	var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
	             + parseInt(computed.getPropertyValue('padding-top'), 10)
	             + field.scrollHeight
	             + parseInt(computed.getPropertyValue('padding-bottom'), 10)
	             + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

	field.style.height = height + 'px';

};

document.addEventListener('input', function (event) {
	if (event.target.tagName.toLowerCase() !== 'textarea') return;
	autoExpand(event.target);
}, false);

/******************
 * 02.Nav Mobile Submenu
 ******************/
var navitem = document.getElementsByClassName('omega-nav-item');
var isItemActiveClass = 'is-active';


for (var i = 0; i < navitem.length; i++) {
    navitem[i].addEventListener('click', menus, false);
}

function menus() {
    var menu = this.querySelector('.omega-submenu');
    menu.parentNode.classList.toggle(isItemActiveClass);
}

/***********************
 * 04.Link Table Target
 **********************/
var tableRows = document.getElementsByClassName('clickable-row');

for (var i = 0, ln = tableRows.length; i < ln; i++) {
	tableRows[i].addEventListener('click', function() {
		window.open(this.getAttribute('data-href'), this.getAttribute('data-target'));
	});
}

/***********************
 * 04.Print contenair ID
 **********************/
function PrintElem(elem)
{
	var printContents = document.getElementById(elem).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}
function PrintElem3(elem)
{
	var mywindow = window.open('', 'PRINT', 'height=400,width=600');

	mywindow.document.write('<html><head><title>' + document.title  + '</title>');
	mywindow.document.write('<link rel="stylesheet" href="http://localhost:8000/layout/admin-default/stylesheets/layout.css" type="text/css" media="print">');
	mywindow.document.write('</head><body >');
	mywindow.document.write('<h1>' + document.title  + '</h1>');
	mywindow.document.write(document.getElementById(elem).innerHTML);
	mywindow.document.write('</body></html>');

	mywindow.document.close(); // necessary for IE >= 10
	mywindow.focus(); // necessary for IE >= 10*/

	mywindow.print();
	mywindow.close();

	return true;
}


/******************
 * 06.Toggle Card
 ******************/
// Click btn expand
const expandBtns = document.querySelectorAll('[data-js-expand]');

if (0 != expandBtns.length) {
	[].forEach.call(expandBtns, (btn) => {
		btn.addEventListener("click", (e) => {
			e.preventDefault();
			const relatedTooglePanelId = btn.dataset.jsExpand;
			const relatedTooglePanel = document.querySelector('[data-js-expanded="' + relatedTooglePanelId +'"]');

			if(!relatedTooglePanel.classList.contains("is-open")) {
				// Adding style and aria to expand div
				relatedTooglePanel.classList.add('is-open');
				relatedTooglePanel.setAttribute('aria-hidden', "false");

				// Set style and aria on related expand btn
				btn.setAttribute("aria-expanded", "true");
				btn.classList.add('is-active');
			} else {
				// Adding style and aria to expand div
				relatedTooglePanel.classList.remove('is-open');
				relatedTooglePanel.setAttribute('aria-hidden', "true");

				// Set style and aria on related expand btn
				btn.setAttribute("aria-expanded", "false");
				btn.classList.remove('is-active');
			}
		});
	})
}

/******************
 * 05.Notifications
 ******************/
setTimeout( function(){
	var oMsg = document.getElementById('notification');
	oMsg.style.display = 'none';
}, 3000);

/**************************
 * 07. Scroll Breadcrumbs
 ************************/
let scrollpos = window.scrollY
const header = document.querySelector(".breadcrumb")
const header_height = header.offsetHeight

const add_class_on_scroll = () => header.classList.add("fade-in")
const remove_class_on_scroll = () => header.classList.remove("fade-in")

window.addEventListener('scroll', function() {
	scrollpos = window.scrollY;

	if (scrollpos >= header_height) { add_class_on_scroll() }
	else { remove_class_on_scroll() }

	console.log(scrollpos)
})