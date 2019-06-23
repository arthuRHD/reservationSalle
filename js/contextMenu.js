//
//Copyright (c) Seagull Consulting, Inc. All rights reserved. See License.txt in the project root for license information.
//
//Version 0.9.1
//Define constructor for TurboTables Library
function ContextMenu() {
	this.MENU_STATE = { OFF: 0, ON: 1 };
	this.menuState = this.MENU_STATE.OFF;
	this.contextMenuActive = 'contextMenu-active';
	this.menu = document.getElementById('context-menu');
	var self = this;

	//Listen for window resized event, so we can turn off menu
     //Turn menu off, if window resized
     window.onresize = function (e) {
               self.ToggleMenuOff();
     };

	//Listen for click event to turn off context menu
	document.addEventListener("click", function(e) {
		var button = e.which || e.button;

		//console.log('Button:', button);
		if (button === 1) {
			self.ToggleMenuOff();;
		}
	});
	
	//Listen for the context menu click (right click) event
	document.addEventListener( "contextmenu", function(e) {
		var element = e.srcElement || e.target;
		var found = false;
		
		//console.log(e);
		//Search for contextMenu-target
		while (! found) {
			if ((element.classList !== undefined) && (element.classList.contains('fc-event')))
				found = true;
			else {
				if (element.parentNode != null)
					element = element.parentNode;
				else
					break;
			}
		}
		//Toggle menu on, if the element is the target
		if (found) {
			e.preventDefault();
			self.PositionMenu(e);
			self.ToggleMenuOn(element);
			//console.log('clicked inside table (' + element.id + ')' );			
		}
		else {
			self.ToggleMenuOff()
			//console.log('clicked outside table.');
		}
	});

    return this;
};		

//Position the context menu propertly
ContextMenu.prototype.PositionMenu = function(e) {
	var clickCoords = this.GetPosition(e);
	var clickCoordsX = clickCoords.x;
	var clickCoordsY = clickCoords.y;
		
	var menuWidth = this.menu.offsetWidth + 4;
	var menuHeight = window.offsetHeight + 4;
	var windowWidth = window.innerWidth;
	var windowHeight = window.innerHeight;
		
	//Make sure we aren't too close to the edge of the window
	if ((windowWidth - clickCoordsX) < menuWidth) {
		this.menu.style.left = windowWidth - menuWidth + "px";			
	} 
	else {
		this.menu.style.left = clickCoordsX + "px";			
	}
	
	if ((windowHeight - clickCoordsY) < menuHeight) {
		this.menu.style.top = windowHeight - menuHeight + "px";			
	}
	else {
		this.menu.style.top = clickCoordsY + "px";			
	}
		
};

//Get the position of the click, so we can place the context menu properly
ContextMenu.prototype.GetPosition = function(e) {
	var posx = 0;
	var posy = 0;

	if (!e) var e = window.event;

		if (e.pageX || e.pageY) {
			posx = e.pageX;
			posy = e.pageY;	
		} 
		else if (e.clientX || e.clientY) {
				posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
				posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
		}

		return { x: posx, y: posy }
	}

//Toggle the context menu on
ContextMenu.prototype.ToggleMenuOn = function(element) {
	var menuItems = null;
	var idx = 0;
	var current = null;
	
	if (this.menuState === this.MENU_STATE.OFF) {
		this.menuState = this.MENU_STATE.ON;
		this.menu.classList.add(this.contextMenuActive);			
	}
		
	menuItems = this.menu.querySelectorAll('.contextMenu-item');
	//Update the menu items for id of the row selected
	for (i = 0; i < menuItems.length; i++) {
		current = menuItems[i].childNodes[1].href;
		idx = current.lastIndexOf('/') + 1;
		menuItems[i].childNodes[1].href = current.substr(0, idx) + element.id;
	}
};

//Toggle the context menu off
ContextMenu.prototype.ToggleMenuOff =function() {
	if (this.menuState === this.MENU_STATE.ON) {
		this.menuState = this.MENU_STATE.OFF;
		this.menu.classList.remove(this.contextMenuActive);			
	}
};
