export default [
  {
    path: "/items",
    component: require("@js/views/items/index.vue").default,
    meta: { resource: "items" },
  },
  {
    path: "/items/create",
    component: require("@js/views/items/form.vue").default,
    meta: { resource: "items", mode: "create" },
  },
  {
    path: "/items/:id/edit",
    component: require("@js/views/items/form.vue").default,
    meta: { resource: "items", mode: "edit" },
  },
  {
    path: "/items/:id",
    component: require("@js/views/items/show.vue").default,
    meta: { resource: "items" },
  },
]
