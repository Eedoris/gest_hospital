<!-- Sidebar -->
<nav class="d-flex flex-column bg-light" style="width: 250px; height: 100vh; border-right: 1px solid #ddd;">
    <!-- Logo / Image -->

    <style>
        .menu .app-brand.demo {
            height: 100px;
            margin-top: 12px;
        }

        .app-brand-logo.demo svg {
            width: 200px;
            height: 180px;
        }
    </style>

    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <ul class="nav flex-column p-2" id="sidebarMenu">
        <!-- Dynamically Generated Menu -->
    </ul>
</nav>

<script>
    const menuData = {

        "menu": [{
                "url": "/patients",
                "name": "Patients",
                "icon": "menu-icon tf-icons bx bx-home-smile",
                "roles": ["secretaire"],
                "slug": "dashboard",
                "submenu": [{
                    "url": "/patients",
                    "name": "Liste",
                    "slug": "dashboard-analytics",
                    "roles": ["secretaire"]
                }]
            },
            {
                "name": "Rendez-vous",
                "icon": "menu-icon tf-icons bx bx-layout",
                "roles": ["secretaire"],
                "slug": "Layouts",
                "submenu": [{
                    "url": "/appointments",
                    "name": "Liste",
                    "slug": "appoint_liste",
                    "roles": ["secretaire"]
                }]
            },
            {
                "name": "Patients",
                "icon": "menu-icon tf-icons bx bx-layout",
                "slug": "Patientsdoc",
                "roles": ["docteur"],
                "submenu": [{
                    "url": "/doctorpat",
                    "name": "Liste",
                    "slug": "layouts-without-menu",
                    "roles": ["docteur"]

                }]
            },
            {
                "url": "/stats",
                "name": "Options",
                "icon": "menu-icon tf-icons bx bx-layout",
                "roles": ["admin"],
                "slug": "Admin",
                "submenu": [{
                        "url": "/stats",
                        "name": "Statistique",
                        "slug": "",
                        "roles": ["admin"]
                    },
                    {
                        "url": "/admin/user",
                        "name": "Gestion des utilisateurs",
                        "slug": "layouts-without-menu",
                        "roles": ["admin"]
                    },
                    {
                        "url": "/admin/doctor",
                        "name": "Gestion des médécins",
                        "slug": "layouts-without-menu",
                        "roles": ["admin"]
                    },
                    {
                        "url": "/adminservice",
                        "name": "Services et spécialités",
                        "slug": "layouts-without-menu",
                        "roles": ["admin"]
                    }
                ]
            }
        ]


    };

    // Simulating user's role (replace with real authentication data)
    const userRole = "secretaire"; // Replace with "secretaire" or "admin" to test.

    const sidebarMenu = document.getElementById("sidebarMenu");

    menuData.menu.forEach(item => {
        if (!item.roles || item.roles.includes(userRole)) {
            const menuItem = document.createElement("li");
            menuItem.classList.add("nav-item");

            // Main menu link
            const link = document.createElement("a");
            link.classList.add("nav-link", "d-flex", "align-items-center");
            link.href = item.url || "#";

            // Icon
            if (item.icon) {
                const icon = document.createElement("i");
                icon.className = `${item.icon} me-2`;
                link.appendChild(icon);
            }

            // Name
            const name = document.createElement("span");
            name.textContent = item.name;
            link.appendChild(name);

            menuItem.appendChild(link);

            // Submenu
            if (item.submenu && item.submenu.length > 0) {
                const submenuList = document.createElement("ul");
                submenuList.classList.add("nav", "flex-column", "ps-3");

                item.submenu.forEach(subitem => {
                    if (!subitem.roles || subitem.roles.includes(userRole)) {
                        const submenuItem = document.createElement("li");
                        submenuItem.classList.add("nav-item");

                        const submenuLink = document.createElement("a");
                        submenuLink.classList.add("nav-link");
                        submenuLink.href = subitem.url;
                        submenuLink.textContent = subitem.name;

                        submenuItem.appendChild(submenuLink);
                        submenuList.appendChild(submenuItem);
                    }
                });

                menuItem.appendChild(submenuList);
            }

            sidebarMenu.appendChild(menuItem);
        }
    });
</script>
