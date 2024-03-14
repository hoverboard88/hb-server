" NOTE: You must have `dense-analysis/ale` installed for this to work.
" TODO: This only works if you `:source init.vim` after starting neovim.
let g:ale_lint_on_enter = 0
let g:ale_echo_msg_format = '[%linter%] %s [%severity%]'
let g:ale_open_list = 1
let g:ale_keep_list_window_open=0
let g:ale_set_quickfix=1
let g:ale_list_window_size = 5
let g:ale_php_phpcs_standard='WordPress'
let g:ale_php_phpcbf_standard='WordPress'
let g:ale_fixers = {
  \ 'php': ['phpcbf'],
  \}
let g:ale_fix_on_save = 1
