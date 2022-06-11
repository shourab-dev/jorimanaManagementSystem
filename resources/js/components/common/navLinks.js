const navLinks = [
    {
        icon: '<i class="fas fa-fw fa-tachometer-alt"></i>',
        name: "Dashboard",
        path: { name: "dashboard" },
    },
    {
        icon: '<i class="fas fa-fw fa-tachometer-alt"></i>',
        name: "Batch & Jorimana",
        path: "#",
        child: [
            {
                name: "Add Batch",
                path: { name: "batch" },
            },
            {
                name: "Fines",
                path: { name: "fines" },
            },
        ],
    },
];

export default navLinks;
