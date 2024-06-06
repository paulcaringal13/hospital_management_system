<template>
  <div
    className="font-montserrat text-slate-800 h-screen max-h-screen flex items-center justify-center bg-slate-100/75"
  >
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",

  data() {
    return {
      apiUrl: "http://127.0.0.1:8000/api",
    };
  },
};
</script>
