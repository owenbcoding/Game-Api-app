# Add this to your ~/.bashrc (or ~/.zshrc) to run `sail` without ./ from anywhere in this project:
#
#   source ~/Projects/Laracast/Game-Api-app/sail.sh
#
# Or copy the function below into your shell config.

sail() {
  local dir="${PWD}"
  while [[ -n "$dir" ]]; do
    if [[ -x "$dir/vendor/bin/sail" ]]; then
      "$dir/vendor/bin/sail" "$@"
      return $?
    fi
    [[ "$dir" == "${dir%/*}" ]] && break
    dir="${dir%/*}"
  done
  echo "Sail not found. Run this from a Laravel Sail project directory." >&2
  return 1
}
