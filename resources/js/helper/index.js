import store from '../store';

export function displayColumn(col) {
  if (this.$store.state.columnPermissions[col] == undefined) {
    return true;
  } else if (this.$store.state.columnPermissions[col] == 0) {
    return false;
  } else {
    return true;
  }
}

export function editColumn(col) {
  if (this.$store.state.columnPermissions[col] == undefined || this.$store.state.columnPermissions[col] == 2) {
    return true;
  } else {
    return false;
  }
}