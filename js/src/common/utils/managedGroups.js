export default function managedGroups(criteria) {
  const ids = criteria
    .filter((criterion) => {
      return criterion.actions();
    })
    .reduce((acc, criterion) => {
      const ids = criterion
        .actions()
        .filter(
          (a) => a.type === "add_to_group" || a.type === "remove_from_group"
        )
        .map((a) => a.settings["group_id"]);
      acc.push(...ids);

      return acc;
    }, []);

  return Array.from(new Set(ids).values())
    .map((groupId) => app.store.getById("groups", groupId))
    .filter((g) => g);
}
