<script type="module">

  let progressBarContainer = document.getElementById('{{ $selector}}');

  let bar = new ProgressBar.Circle(progressBarContainer, {
    color: 'white',
    strokeWidth: 6,
    trailWidth: 3,
    trailColor: '#4A5568',
    easing: 'easeInOut',
    duration: 1800,
    text: {
      autoStyleContainer: false,
    },
    svgStyle: {position: 'absolute', top: '0'},
    from: { color: '#48BB78', width: 6 },
    to: { color: '#48BB78', width: 6 },
    // Set default step function for all animate calls
    step: function(state, circle) {
      circle.path.setAttribute('stroke', state.color);
      circle.path.setAttribute('stroke-width', state.width);
      let value = Math.round(circle.value() * 100);
      if (value === 0) {
        circle.setText('0%');
      } else {
        circle.setText(value+'%');
      }
    }
  });

  bar.animate({{ $rating }} / 100);

</script>
