// plugins/PermissionPlugin.js
import { usePage } from '@inertiajs/vue3';

const PermissionPlugin = {
  install: (app) => {
    app.config.globalProperties.$can = function (value) {
      const { props } = usePage();

      const permissions = props.auth?.user?.permissions || [];
      let result = false;
      if (!Array.isArray(permissions)) {
        return false;
      }
      if (value.includes("|")) {
        value.split("|").forEach(item => {
          if (permissions.includes(item.trim())) {
            result = true;
          }
        });
      } else if (value.includes("&")) {
        result = true;
        value.split("&").forEach(item => {
          if (!permissions.includes(item.trim())) {
            result = false;
          }
        });
      } else {
        result = permissions.includes(value.trim());
      }
      return result;
    };

    app.config.globalProperties.$is = function (value) {
      const { props } = usePage();
      const roles = props.auth?.user?.roles || [];
      let result = false;
      if (!Array.isArray(roles)) {
        return false;
      }
      if (value.includes("|")) {
        value.split("|").forEach(item => {
          if (roles.includes(item.trim())) {
            result = true;
          }
        });
      } else if (value.includes("&")) {
        result = true;
        value.split("&").forEach(item => {
          if (!roles.includes(item.trim())) {
            result = false;
          }
        });
      } else {
        result = roles.includes(value.trim());
      }
      return result;
    };
  }
};

export default PermissionPlugin;
