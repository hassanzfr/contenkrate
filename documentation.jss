// Documentation Page JavaScript
// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.remove('active');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab content
    const targetTab = document.getElementById(tabName);
    if (targetTab) {
        targetTab.classList.add('active');
    }
    
    // Add active class to clicked button
    const clickedButton = document.querySelector(`[onclick="switchTab('${tabName}')"]`);
    if (clickedButton) {
        clickedButton.classList.add('active');
    }
}

// Initialize documentation functionality when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Documentation page loaded');
    
    // Set up tab button event listeners (alternative to onclick)
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Determine which tab to show based on button text
            const buttonText = this.textContent.toLowerCase();
            if (buttonText.includes('front')) {
                switchTab('frontend');
            } else if (buttonText.includes('back')) {
                switchTab('backend');
            }
        });
    });

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.doc-nav a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                // Scroll to section with offset for sticky header
                const headerHeight = document.querySelector('.doc-header').offsetHeight;
                const elementPosition = targetSection.offsetTop;
                const offsetPosition = elementPosition - headerHeight - 20;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Update active nav item
                document.querySelectorAll('.doc-nav li').forEach(li => {
                    li.classList.remove('active');
                });
                this.parentElement.classList.add('active');
            }
        });
    });

    // Update active nav item on scroll
    const sections = document.querySelectorAll('.doc-section');
    const navItems = document.querySelectorAll('.doc-nav li');

    function updateActiveNavItem() {
        let current = '';
        const headerHeight = document.querySelector('.doc-header').offsetHeight;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - headerHeight - 50;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionBottom) {
                current = section.getAttribute('id');
            }
        });

        navItems.forEach(li => {
            li.classList.remove('active');
            const link = li.querySelector('a');
            if (link && link.getAttribute('href') === '#' + current) {
                li.classList.add('active');
            }
        });
    }

    // Throttled scroll event listener for better performance
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(updateActiveNavItem, 10);
    });

    // Initial call to set active nav item
    updateActiveNavItem();
});

// Additional utility functions
function showSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Debug function to check if tabs are working
function debugTabs() {
    console.log('Frontend tab:', document.getElementById('frontend'));
    console.log('Backend tab:', document.getElementById('backend'));
    console.log('Tab buttons:', document.querySelectorAll('.tab-btn'));
}