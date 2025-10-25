import { usePage } from '@inertiajs/vue3';

const PermissionPlugin = {
  install(app) {
    /* -------------------------------------------------- *
     * $can  – permission check                          *
     * -------------------------------------------------- */
    app.config.globalProperties.$can = function (value) {
      const { props } = usePage();

      /* helper: return every name we should recognise
         - user :         p.name
         - strings:                 leave as‑is                                   */
      const extractNames = (list) =>
        list
          .flatMap(p => {
            if (typeof p === 'string') return p;
            const names = [];
            if (p?.name) names.push(p.name);
            if (p?.group_name?.name) names.push(p.group_name.name);
            return names;
          })
          .filter(Boolean);          // remove undefined / null

      /* 1. user.permissions */
      const userPerms = extractNames(props.auth?.user?.permissions || []);

      /* combine + dedupe */
      const permissions = Array.from(new Set([...userPerms]));

      /* evaluation */
      const test = perm => permissions.includes(perm.trim());

      if (value.includes('|')) return value.split('|').some(test);   // OR
      if (value.includes('&')) return value.split('&').every(test);  // AND
      return test(value);                                            // single
    };

    /* -------------------------------------------------- *
     * $is – role check (unchanged)                       *
     * -------------------------------------------------- */
    app.config.globalProperties.$is = function (value) {
      const { props } = usePage();
      const roles = props.auth?.user?.roles || [];
      if (!Array.isArray(roles)) return false;

      // Extract role names from role objects
      const roleNames = roles.map(role =>
        typeof role === 'object' ? role.name : role
      );

      const test = role => roleNames.includes(role.trim());

      if (value.includes('|')) return value.split('|').some(test);
      if (value.includes('&')) return value.split('&').every(test);
      return test(value);
    };

  }
};

export default PermissionPlugin;
