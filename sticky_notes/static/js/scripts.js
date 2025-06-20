window.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search');
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      const query = searchInput.value.toLowerCase();
      document.querySelectorAll('#notes .note').forEach(note => {
        note.style.display = note.innerText.toLowerCase().includes(query) ? '' : 'none';
      });
    });
  }
});
