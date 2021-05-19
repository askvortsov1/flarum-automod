export default function managedGroups(criteria) {
  return criteria
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
    }, [])
    .map((groupId) => app.store.getById("groups", groupId))
    .filter((g) => g);
}
