/**
 * @class L.Draw.Rectangle
 * @aka Draw.Rectangle
 * @inherits L.Draw.SimpleShape
 */
L.Draw.Rectangle = L.Draw.SimpleShape.extend({
	statics: {
		TYPE: 'rectangle'
	},

	options: {
		shapeOptions: {
			stroke: true,
			color: '#DA4D01',
			weight: 4,
			opacity: 0.5,
			fill: true,
			fillColor: null, //same as color by default
			fillOpacity: 0.2,
			showArea: true,
			clickable: true
		},
		metric: true // Whether to use the metric measurement system or imperial
	},

	// @method initialize(): void
	initialize: function (map, options) {
		// Save the type so super can fire, need to do this as cannot do this.TYPE :(
		this.type = L.Draw.Rectangle.TYPE;

		this._initialLabelText = L.drawLocal.draw.handlers.rectangle.tooltip.start;

		L.Draw.SimpleShape.prototype.initialize.call(this, map, options);
	},

	// GOPAL 2017 - chose color 
	// ngubah warna garis, via toolbar action. bukan draw control lg. biar g makan tempat
	chosecolorwhite: function () {
		this.options.shapeOptions.color = '#ffffff';
	},
	chosecolorblack: function () {
		this.options.shapeOptions.color = '#000000';
	},
	chosecoloryellow: function () {
		this.options.shapeOptions.color = '#ffff00';
	},
	chosecolordefault: function () {
		this.options.shapeOptions.color = '#DA4D01';
	},
	chosecolorblue: function () {
		this.options.shapeOptions.color = '#0066ff';
	},
	chosecolorgreen: function () {
		this.options.shapeOptions.color = '#029A10';
	},
	chosecolorpurple: function () {
		this.options.shapeOptions.color = '#cc00cc';
	},
	chosecolorgray: function () {
		this.options.shapeOptions.color = '#808080';
	},
	chosecolorred: function () {
		this.options.shapeOptions.color = '#ff0000';
	},

	_drawShape: function (latlng) {
		if (!this._shape) {
			this._shape = new L.Rectangle(new L.LatLngBounds(this._startLatLng, latlng), this.options.shapeOptions);
			this._map.addLayer(this._shape);
		} else {
			this._shape.setBounds(new L.LatLngBounds(this._startLatLng, latlng));
		}
	},

	_fireCreatedEvent: function () {
		var rectangle = new L.Rectangle(this._shape.getBounds(), this.options.shapeOptions);
		L.Draw.SimpleShape.prototype._fireCreatedEvent.call(this, rectangle);
	},

	_getTooltipText: function () {
		var tooltipText = L.Draw.SimpleShape.prototype._getTooltipText.call(this),
			shape = this._shape,
			showArea = this.options.showArea,
			latLngs, area, subtext;

		if (shape) {
			latLngs = this._shape._defaultShape ? this._shape._defaultShape() : this._shape.getLatLngs();
			area = L.GeometryUtil.geodesicArea(latLngs);
			subtext = showArea ? L.GeometryUtil.readableArea(area, this.options.metric) : ''
		}

		return {
			text: tooltipText.text,
			subtext: subtext
		};
	}
});
