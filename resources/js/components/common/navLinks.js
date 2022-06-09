const navLinks = [
    {
        icon: '<i class="fas fa-fw fa-tachometer-alt"></i>',
        name: "Dashboard",
        path: { name: "dashboard" },
    },
    {
        icon: '<i class="fas fa-fw fa-tachometer-alt"></i>',
        name: "Jorimana",
        path: { name: "dashboard" },
        child: [
            {
                name: "Add Jorimana",
                path: { name: "dashboard" },
            },
        ],
    },
];

export default navLinks;
