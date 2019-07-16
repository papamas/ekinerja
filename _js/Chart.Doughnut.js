(function () {
    "use strict";

    var root = this,
            Chart2 = root.Chart2,
            //Cache a local reference to Chart2.helpers
            helpers = Chart2.helpers;

    var defaultConfig = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,

        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",

        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,

        //The percentage of the chart that we cut out of the middle.
        percentageInnerCutout: 50,

        //Number - Amount of animation steps
        animationSteps: 100,

        //String - Animation easing effect
        animationEasing: "easeOutBounce",

        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,

        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,

        // String - Template string for single tooltips
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= numeral(value).format('0,0[.]00')%> (<%= numeral(circumference / 6.283).format('(0[.][00]%)') %>)",

        labelFontFamily: "Arial",
        labelFontStyle: "normal",
        labelFontSize: 24,
        labelFontColor: "#666",

        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span></li><%}%></ul>"

    };

    Chart2.Type.extend({
        //Passing in a name registers this chart in the Chart2 namespace
        name: "Doughnut",
        //Providing a defaults will also register the deafults in the chart namespace
        defaults: defaultConfig,
        //Initialize is fired when the chart is initialized - Data is passed in as a parameter
        //Config is automatically merged by the core of Chart2.js, and is available at this.options
        initialize: function (data) {

            //Declare segments as a static property to prevent inheriting across the Chart2 type prototype
            this.segments = [];
            this.outerRadius = (helpers.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2;

            this.SegmentArc = Chart2.Arc.extend({
                ctx: this.chart.ctx,
                x: this.chart.width / 2,
                y: this.chart.height / 2
            });

            //Set up tooltip events on the chart
            if (this.options.showTooltips) {
                helpers.bindEvents(this, this.options.tooltipEvents, function (evt) {
                    var activeSegments = (evt.type !== 'mouseout') ? this.getSegmentsAtEvent(evt) : [];

                    helpers.each(this.segments, function (segment) {
                        segment.restore(["fillColor"]);
                    });
                    helpers.each(activeSegments, function (activeSegment) {
                        activeSegment.fillColor = activeSegment.highlightColor;
                    });
                    this.showTooltip(activeSegments);
                });
            }
            this.calculateTotal(data);

            helpers.each(data, function (datapoint, index) {
                if (!datapoint.color) {
                    datapoint.color = 'hsl(' + (360 * index / data.length) + ', 100%, 50%)';
                }
                this.addData(datapoint, index, true);
            }, this);

            this.render();
        },
        getSegmentsAtEvent: function (e) {
            var segmentsArray = [];

            var location = helpers.getRelativePosition(e);

            helpers.each(this.segments, function (segment) {
                if (segment.inRange(location.x, location.y))
                    segmentsArray.push(segment);
            }, this);
            return segmentsArray;
        },
        addData: function (segment, atIndex, silent) {
            var index = atIndex || this.segments.length;
            this.segments.splice(index, 0, new this.SegmentArc({
                value: segment.value,
                outerRadius: (this.options.animateScale) ? 0 : this.outerRadius,
                innerRadius: (this.options.animateScale) ? 0 : (this.outerRadius / 100) * this.options.percentageInnerCutout,
                fillColor: segment.color,
                highlightColor: segment.highlight || segment.color,
                showStroke: this.options.segmentShowStroke,
                strokeWidth: this.options.segmentStrokeWidth,
                strokeColor: this.options.segmentStrokeColor,
                startAngle: Math.PI * 1.5,
                circumference: (this.options.animateRotate) ? 0 : this.calculateCircumference(segment.value),
                label: segment.label
            }));
            if (!silent) {
                this.reflow();
                this.update();
            }
        },
        calculateCircumference: function (value) {
            if (this.total > 0) {
                return (Math.PI * 2) * (value / this.total);
            } else {
                return 0;
            }
        },
        calculateTotal: function (data) {
            this.total = 0;
            helpers.each(data, function (segment) {
                this.total += Math.abs(segment.value);
            }, this);
        },
        update: function () {
            this.calculateTotal(this.segments);

            // Reset any highlight colours before updating.
            helpers.each(this.activeElements, function (activeElement) {
                activeElement.restore(['fillColor']);
            });

            helpers.each(this.segments, function (segment) {
                segment.save();
            });
            this.render();
        },

        removeData: function (atIndex) {
            var indexToDelete = (helpers.isNumber(atIndex)) ? atIndex : this.segments.length - 1;
            this.segments.splice(indexToDelete, 1);
            this.reflow();
            this.update();
        },

        reflow: function () {
            helpers.extend(this.SegmentArc.prototype, {
                x: this.chart.width / 2,
                y: this.chart.height / 2
            });
            this.outerRadius = (helpers.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2;
            helpers.each(this.segments, function (segment) {
                segment.update({
                    outerRadius: this.outerRadius,
                    innerRadius: (this.outerRadius / 100) * this.options.percentageInnerCutout
                });
            }, this);
        },
        draw: function (easeDecimal) {
            var animDecimal = (easeDecimal) ? easeDecimal : 1;
            this.clear();
            helpers.each(this.segments, function (segment, index) {
                segment.transition({
                    circumference: this.calculateCircumference(segment.value),
                    outerRadius: this.outerRadius,
                    innerRadius: (this.outerRadius / 100) * this.options.percentageInnerCutout
                }, animDecimal);

                segment.endAngle = segment.startAngle + segment.circumference;

                segment.draw();
                if (index === 0) {
                    segment.startAngle = Math.PI * 1.5;
                }
                //Check to see if it's the last segment, if not get the next and update the start angle
                if (index < this.segments.length - 1) {
                    this.segments[index + 1].startAngle = segment.endAngle;
                }
            }, this);

        }
    });

    Chart2.types.Doughnut.extend({
        name: "Pie",
        defaults: helpers.merge(defaultConfig, {percentageInnerCutout: 0})
    });

}).call(this);
