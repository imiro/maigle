/**
 * @class L.DrawToolbar
 * @aka Toolbar
 */
L.DrawToolbar = L.Toolbar.extend({

	statics: {
		TYPE: 'draw'
	},

	options: {
		polyline: {},
		polygon: {},
		rectangle: {},
		circle: {},
		marker: {},
		markerbulat: {}
		// markerabu: {},
		// markermerah: {},
		// markerhijau: {},
		// markerbiru: {},
		// markerungu: {}
	},

	// @method initialize(): void
	initialize: function (options) {
		// Ensure that the options are merged correctly since L.extend is only shallow
		for (var type in this.options) {
			if (this.options.hasOwnProperty(type)) {
				if (options[type]) {
					options[type] = L.extend({}, this.options[type], options[type]);
				}
			}
		}

		this._toolbarClass = 'leaflet-draw-draw';
		L.Toolbar.prototype.initialize.call(this, options);
	},

	// @method getModeHandlers(): object
	// Get mode handlers information
	getModeHandlers: function (map) {
		return [
			{
				enabled: this.options.polyline,
				handler: new L.Draw.Polyline(map, this.options.polyline),
				title: L.drawLocal.draw.toolbar.buttons.polyline
			},
			{
				enabled: this.options.polygon,
				handler: new L.Draw.Polygon(map, this.options.polygon),
				title: L.drawLocal.draw.toolbar.buttons.polygon
			},
			{
				enabled: this.options.rectangle,
				handler: new L.Draw.Rectangle(map, this.options.rectangle),
				title: L.drawLocal.draw.toolbar.buttons.rectangle
			},
			{
				enabled: this.options.circle,
				handler: new L.Draw.Circle(map, this.options.circle),
				title: L.drawLocal.draw.toolbar.buttons.circle
			},
			{
				enabled: this.options.marker,
				handler: new L.Draw.Marker(map, this.options.marker),
				title: L.drawLocal.draw.toolbar.buttons.marker
			},
			{
				enabled: this.options.markerbulat,
				handler: new L.Draw.MarkerBulat(map, this.options.markerbulat),
				title: L.drawLocal.draw.toolbar.buttons.markerbulat
			},
			// {
			// 	enabled: this.options.markerabu,
			// 	handler: new L.Draw.MarkerAbu(map, this.options.markerabu),
			// 	title: L.drawLocal.draw.toolbar.buttons.markerabu
			// },
			// {
			// 	enabled: this.options.markermerah,
			// 	handler: new L.Draw.MarkerMerah(map, this.options.markermerah),
			// 	title: L.drawLocal.draw.toolbar.buttons.markermerah
			// },
			// {
			// 	enabled: this.options.markerhijau,
			// 	handler: new L.Draw.MarkerHijau(map, this.options.markerhijau),
			// 	title: L.drawLocal.draw.toolbar.buttons.markerhijau
			// },
			// {
			// 	enabled: this.options.markerbiru,
			// 	handler: new L.Draw.MarkerBiru(map, this.options.markerbiru),
			// 	title: L.drawLocal.draw.toolbar.buttons.markerbiru
			// },
			// {
			// 	enabled: this.options.markerungu,
			// 	handler: new L.Draw.MarkerUngu(map, this.options.markerungu),
			// 	title: L.drawLocal.draw.toolbar.buttons.markerungu
			// }
		];
	},

	// @method getActions(): object
	// Get action information
	getActions: function (handler) {
		return [
			{
				enabled: handler.chosecolordefault,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.adefault,
				callback: handler.chosecolordefault,
				context: handler
			},
			{
				enabled: handler.chosecolorwhite,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.awhite,
				callback: handler.chosecolorwhite,
				context: handler
			},
			{
				enabled: handler.chosecolorgray,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.agray,
				callback: handler.chosecolorgray,
				context: handler
			},
			{
				enabled: handler.chosecolorblack,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.ablack,
				callback: handler.chosecolorblack,
				context: handler
			},
			{
				enabled: handler.chosecolorred,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.ared,
				callback: handler.chosecolorred,
				context: handler
			},
			{
				enabled: handler.chosecolorpurple,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.apurple,
				callback: handler.chosecolorpurple,
				context: handler
			},
			{
				enabled: handler.chosecolorgreen,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.agreen,
				callback: handler.chosecolorgreen,
				context: handler
			},
			{
				enabled: handler.chosecolorblue,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.ablue,
				callback: handler.chosecolorblue,
				context: handler
			},
			{
				enabled: handler.chosecoloryellow,
				title: L.drawLocal.draw.toolbar.chosecolor.title,
				text: L.drawLocal.draw.toolbar.chosecolor.ayellow,
				callback: handler.chosecoloryellow,
				context: handler
			},
			//beres chose color
			{
				enabled: handler.completeShape,
				title: L.drawLocal.draw.toolbar.finish.title,
				text: L.drawLocal.draw.toolbar.finish.text,
				callback: handler.completeShape,
				context: handler
			},
			{
				enabled: handler.deleteLastVertex,
				title: L.drawLocal.draw.toolbar.undo.title,
				text: L.drawLocal.draw.toolbar.undo.text,
				callback: handler.deleteLastVertex,
				context: handler
			},
			{
				title: L.drawLocal.draw.toolbar.actions.title,
				text: L.drawLocal.draw.toolbar.actions.text,
				callback: this.disable,
				context: this
			}
		];
	},

	// @method setOptions(): void
	// Sets the options to the toolbar
	setOptions: function (options) {
		L.setOptions(this, options);

		for (var type in this._modes) {
			if (this._modes.hasOwnProperty(type) && options.hasOwnProperty(type)) {
				this._modes[type].handler.setOptions(options[type]);
			}
		}
	}
});
