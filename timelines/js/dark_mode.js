


$(document).ready(function () {
  // Check saved theme on load
  if (localStorage.getItem('theme') === 'dark') {
    $('body').addClass('dark-mode');
    $('.theme-toggle').html('<i class="fas fa-sun"></i>');
  } else {
    $('.theme-toggle').html('<i class="fas fa-moon"></i>');
  }

  // Toggle theme
  $('.theme-toggle').click(function () {
    $('body').toggleClass('dark-mode');
    const isDark = $('body').hasClass('dark-mode');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    $(this).html(isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>');
  });

  // 3D animations
  $('.category-card, .trending-item, .product-card').hover(
    function () {
      $(this).css('transform', 'translateY(-10px)');
    },
    function () {
      $(this).css('transform', 'translateY(0)');
    }
  );
});

