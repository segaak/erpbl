const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

// Apply the active class based on localStorage
document.addEventListener('DOMContentLoaded', () => {
    const activePage = localStorage.getItem('activePage');
    if (activePage) {
        allSideMenu.forEach(item => {
            if (item.getAttribute('href') === activePage) {
                item.parentElement.classList.add('active');
            } else {
                item.parentElement.classList.remove('active');
            }
        });
    }
});

// Add click event listeners to update the active class and store in localStorage
allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function (e) {
        // HAPUS e.preventDefault() - biarkan navigasi normal berjalan
        
        // Remove active class from all menu items
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });

        // Add active class to the clicked menu item
        li.classList.add('active');

        // Store the clicked menu item's href in localStorage
        const href = item.getAttribute('href');
        localStorage.setItem('activePage', href);

        // Tidak perlu window.location.href karena link akan navigate secara normal
    });
});

// Clear active state on logout
const logoutButton = document.querySelector('.logout');
if (logoutButton) {
    logoutButton.addEventListener('click', () => {
        localStorage.removeItem('activePage');
    });
}

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		// e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['100k', '200k', '300k', '400k', '500k', '600k', '700k', '800k', '900k', '1000k', '1100k', '1200k'],
      datasets: [{
        label: 'Penjualan',
        data: [25, 40, 35, 90, 45, 60, 20, 35, 80, 70, 65, 60],
        backgroundColor: 'rgba(93, 135, 255, 0.2)',
        borderColor: 'rgba(93, 135, 255, 1)',
        borderWidth: 2,
        tension: 0.3,
        fill: true,
        pointBackgroundColor: 'rgba(93, 135, 255, 1)',
        pointRadius: 4,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return new Intl.NumberFormat('id-ID').format(context.raw);
            }
          }
        },
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          min: 0,
          max: 100,
          ticks: {
            callback: function(value) {
              return value + '%';
            }
          }
        }
      }
    }
  });
