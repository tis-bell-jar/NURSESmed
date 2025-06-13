{{-- resources/views/partials/chatbot.blade.php --}}

<style>
  /* ——— The round toggle button ——— */
#chat-toggle {
  position: fixed;
  bottom: 1.5rem;
  right: 1.5rem;
  width: 60px;
  height: 60px;
  border: none;
  border-radius: 50%;
  /* ← swapped in a robot-bot SVG from the web: */
  background: #2c7a36 url('https://img.icons8.com/ios-filled/64/ffffff/robot-2.png') center/contain no-repeat;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  z-index: 1000;  /* above everything else */
}




  /* ——— The chat panel, hidden by default ——— */
  #chat-panel {
    display: none;                /* hidden until toggled */
    position: fixed;
    bottom: calc(1.5rem + 60px + 0.5rem); /* just above the toggle */
    right: 1.5rem;
    width: 400px;                 /* your desired width */
    height: 570px;                /* your desired height */
    max-width: 90vw;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    overflow: hidden;
    z-index: 999;                 /* under the toggle */
  }

  /* ——— When open, show it ——— */
  #chat-panel.open {
    display: block;
  }

  /* ——— The iframe inside ——— */
  #external-chat {
    width: 100%;
    height: 100%;
    border: none;
    pointer-events: auto;
  }

  @media (max-width: 600px) {
  #chat-toggle {
    right: 1rem;
    bottom: 5.8rem;   /* Raise up above the other button */
    width: 52px;
    height: 52px;
  }
  #chat-panel {
    right: 0.5rem;
    width: 99vw;
    min-width: 0;
    max-width: 99vw;
    height: 75vh;
    border-radius: 13px;
    bottom: calc(5.8rem + 52px + 0.5rem); /* just above the toggle */
  }
}

</style>

<!-- your toggle button -->
<button id="chat-toggle" aria-label="Toggle chat"></button>

<!-- the separate chat window -->
<div id="chat-panel">
  <iframe
    id="external-chat"
    src="https://nursesmed.onrender.com?embed=1"
    allow="microphone; clipboard-write"
    title="Zendawa Assistant">
  </iframe>
</div>

<script>
  const toggleBtn = document.getElementById('chat-toggle');
  const chatPanel = document.getElementById('chat-panel');

  toggleBtn.addEventListener('click', () => {
    chatPanel.classList.toggle('open');
  });
</script>
