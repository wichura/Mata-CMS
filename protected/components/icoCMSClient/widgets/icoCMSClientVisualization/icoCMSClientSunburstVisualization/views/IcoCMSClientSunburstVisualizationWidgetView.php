<div id="<?php echo $this->id ?>"></div>
<script>
    
    
    var width = $($("#<?php echo $this->id ?>").parents()[0]).width(),
    baseColour = "<?php echo $this->visualization->getMeta("Color") ?>",
    height = width,
    radius = width / 2,
    x = d3.scale.linear().range([0, 2 * Math.PI]),
    y = d3.scale.pow().exponent(1.3).domain([0, 1]).range([0, radius]),
    padding = 5,
    duration = 1000;

    var div = d3.select("#<?php echo $this->id ?>");

    div.select("img").remove();

    var vis = div.append("svg")
    .attr("width", width + padding * 2)
    .attr("height", height + padding * 2)
    .append("g")
    .attr("transform", "translate(" + [radius + padding, radius + padding] + ")");

    var partition = d3.layout.partition()
    .sort(null)
    .value(function(d) {
        return 5.8 - d.depth;
    });

    var arc = d3.svg.arc()
    .startAngle(function(d) {
        return Math.max(0, Math.min(2 * Math.PI, x(d.x)));
    })
    .endAngle(function(d) {
        return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx)));
    })
    .innerRadius(function(d) {
        return Math.max(0, d.y ? y(d.y) : d.y);
    })
    .outerRadius(function(d) {
        return Math.max(0, y(d.y + d.dy));
    });

    var json = <?php echo $this->visualization->Data ?>;
    var nodes = partition.nodes({
        children: json
    });

    var path = vis.selectAll("path").data(nodes);
    path.enter().append("path")
    .attr("id", function(d, i) {
        return "path-" + i;
    })
    .attr("d", arc)
    .attr("fill-rule", "evenodd")
    .style("fill", colour)
    .style("stroke", "<?php echo $this->visualization->getMeta("StrokeColor") ?>")
    .style("stroke-width", "<?php echo $this->visualization->getMeta("StrokeThickness") ?>")
    .on("click", click);

    var text = vis.selectAll("text").data(nodes);
    var textEnter = text.enter().append("text")
    .style("fill-opacity", 1)
    .style("fill", function(d) {
        return brightness(d3.rgb(colour(d))) < 125 ? "#eee" : "#000";
    })
    .attr("text-anchor", function(d) {
        return x(d.x + d.dx / 2) > Math.PI ? "end" : "start";
    })
    .attr("dy", ".2em")
    .attr("transform", function(d) {
        var multiline = (d.data || "").split(" ").length > 1,
        angle = x(d.x + d.dx / 2) * 180 / Math.PI - 90,
        rotate = angle + (multiline ? -.5 : 0);
        return "rotate(" + rotate + ")translate(" + (y(d.y) + padding) + ")rotate(" + (angle > 90 ? -180 : 0) + ")";
    })
    .on("click", click);
    textEnter.append("tspan")
    .attr("x", 0)
    .text(function(d) {
        return d.depth ? d.data.split(" ")[0] : "";
    });
    textEnter.append("tspan")
    .attr("x", 0)
    .attr("dy", "1em")
    .text(function(d) {
        return d.depth ? d.data.split(" ")[1] || "" : "";
    });


</script>