<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-mini-width: 80px;
            --sidebar-bg: #343a40;
            --sidebar-color: #dee2e6;
            --sidebar-active-bg: #007bff;
            --sidebar-active-color: white;
            --sidebar-hover-bg: #495057;
            --sidebar-hover-color: white;
            --header-height: 56px;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            transition: margin-left var(--transition-speed);
        }
        
        /* Sidebar styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            transition: all var(--transition-speed);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar.minimized {
            width: var(--sidebar-mini-width);
        }
        
        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: var(--header-height);
            min-height: var(--header-height);
        }
        
        .sidebar-header h5 {
            white-space: nowrap;
            margin: 0;
            transition: opacity var(--transition-speed);
        }
        
        .sidebar.minimized .sidebar-header h5 {
            opacity: 0;
            width: 0;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            position: relative;
            white-space: nowrap;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-color);
            text-decoration: none;
            transition: all var(--transition-speed);
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover {
            background: var(--sidebar-hover-bg);
            color: var(--sidebar-hover-color);
            border-left-color: var(--sidebar-active-bg);
        }
        
        .sidebar-menu a.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            border-left-color: var(--sidebar-active-color);
        }
        
        .sidebar-menu i {
            min-width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.2rem;
            transition: margin var(--transition-speed);
        }
        
        .sidebar.minimized .sidebar-menu i {
            margin-right: 0;
            font-size: 1.4rem;
        }
        
        .sidebar-menu span {
            transition: opacity var(--transition-speed), width var(--transition-speed);
        }
        
        .sidebar.minimized .sidebar-menu span {
            opacity: 0;
            width: 0;
        }
        
        /* Main content area */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed);
        }
        
        body.minimized .main-content {
            margin-left: var(--sidebar-mini-width);
        }
        
        /* Header styles */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            transition: all var(--transition-speed);
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        
        body.minimized .topbar {
            left: var(--sidebar-mini-width);
        }
        
        /* Toggle button styles */
        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--sidebar-color);
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform var(--transition-speed);
        }
        
        .sidebar.minimized .sidebar-toggle {
            transform: rotate(180deg);
        }
        
        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                z-index: 1100;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .topbar {
                left: 0;
            }
            
            #sidebarCollapse {
                display: block;
            }
            
            body.minimized .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
        }
        
        /* Tooltip for minimized sidebar */
        .sidebar.minimized .sidebar-menu a {
            position: relative;
        }
        
        .sidebar.minimized .sidebar-menu a::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--sidebar-bg);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            margin-left: 10px;
            z-index: 1001;
        }
        
        .sidebar.minimized .sidebar-menu a:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5>E-Learning</h5>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="../index.php" class="active" data-tooltip="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../classes/" data-tooltip="Classes">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Classes</span>
                </a>
            </li>
            <li>
                <a href="../courses/" data-tooltip="Courses">
                    <i class="bi bi-collection-play"></i>
                    <span>Courses</span>
                </a>
            </li>
            <li>
                <a href="../lessons/" data-tooltip="Lessons">
                    <i class="bi bi-film"></i>
                    <span>Lessons</span>
                </a>
            </li>
            <li>
                <a href="#" data-tooltip="Users">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="#" data-tooltip="Settings">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="mt-4">
                <a href="#" data-tooltip="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Topbar -->
    <nav class="topbar">
        <button id="sidebarCollapse" class="btn btn-link d-md-none">
            <i class="bi bi-list"></i>
        </button>
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 d-none d-lg-inline text-muted small">Admin User</span>
            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/40x40" width="40" height="40">
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar between full and minimized states
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('minimized');
            document.body.classList.toggle('minimized');
        });
        
        // Mobile sidebar toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Highlight active menu item
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        const menuItems = document.querySelectorAll('.sidebar-menu a');
        
        menuItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && currentPage.includes(href.split('/').pop())) {
                item.classList.add('active');
            }
        });
        
        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarCollapse');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                event.target !== toggleBtn && 
                !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>