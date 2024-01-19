<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>
<body>
<div id="allSampleContent" class="p-4 w-full">
    <div id="sample">
        <div id="myDiagramDiv"
             style="background-color: white; border: 1px solid black; width: 100%; height: 500px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0);">
            <canvas tabindex="0" width="1039" height="498"
                    style="position: absolute; top: 0px; left: 0px; z-index: 2; user-select: none; touch-action: none; width: 1039px; height: 498px;"></canvas>
            <div style="position: absolute; overflow: auto; width: 1039px; height: 498px; z-index: 1;">
                <div style="position: absolute; width: 1px; height: 1px;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/gojs@2.3.12/release/go.js"></script>
<script src="https://unpkg.com/gojs@2.3.12/extensions/DoubleTreeLayout.js"></script>
<script id="code">

    function init() {
        const $ = go.GraphObject.make;  // for conciseness in defining templates

        myDiagram =
            new go.Diagram("myDiagramDiv",  // must name or refer to the DIV HTML element
                {
                    initialAutoScale: go.Diagram.Uniform,  // an initial automatic zoom-to-fit
                    contentAlignment: go.Spot.Center,  // align document to the center of the viewport
                    layout:
                        $(go.ForceDirectedLayout,  // automatically spread nodes apart
                            { maxIterations: 200, defaultSpringLength: 30, defaultElectricalCharge: 100 })
                });

        // define each Node's appearance
        myDiagram.nodeTemplate =
            $(go.Node, "Auto",  // the whole node panel
                { locationSpot: go.Spot.Center },
                // define the node's outer shape, which will surround the TextBlock
                $(go.Shape, "RoundedRectangle",
                    { fill: $(go.Brush, "Linear", { 0: "rgb(254, 201, 0)", 1: "rgb(254, 162, 0)" }), stroke: "black" }),
                $(go.TextBlock,
                    { font: "bold 12pt helvetica, bold arial, sans-serif", margin: 4 },
                    new go.Binding("text", "text"))
            );

        // replace the default Link template in the linkTemplateMap
        myDiagram.linkTemplate =
            $(go.Link,  // the whole link panel
                { routing: go.Link.Orthogonal,  // may be either Orthogonal or AvoidsNodes
                    curve: go.Link.JumpOver },
                $(go.Shape,  // the link shape
                    { stroke: "black" }),
                $(go.Shape,  // the arrowhead
                    { toArrow: "standard", stroke: null }),
                $(go.Panel, "Auto",
                    $(go.Shape,  // the label background, which becomes transparent around the edges
                        {
                            fill: $(go.Brush, "Radial", { 0: "rgb(240, 240, 240)", 0.3: "rgb(240, 240, 240)", 1: "rgba(240, 240, 240, 0)" }),
                            stroke: null
                        }),
                    $(go.TextBlock,  // the label text
                        {
                            textAlign: "center",
                            font: "10pt helvetica, arial, sans-serif",
                            stroke: "#555555",
                            margin: 4
                        },
                        new go.Binding("text", "text"))
                )
            );

        // Make a GET request using the Fetch API
        fetch('/syndicates/orgchart/data?model_id={{ $model_id }}&model_type={{$model_type}}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(userData => {
                // Process the retrieved user data
                console.log('User Data:', userData);
                myDiagram.model = new go.GraphLinksModel(userData.text, userData.label);
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }
    window.addEventListener('DOMContentLoaded', init);
</script>
</body>
</html>
