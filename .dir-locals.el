(
 (nil . ((tab-width . 4)
         (js-indent-level . 4)

         ;; css-mode does not give us the option to use tabs, so we
         ;; need to make use of web-mode for css files.
         ;; (eval . (add-to-list 'auto-mode-alist '("\\.css\\'" . web-mode)))
         ;; (eval . (add-to-list 'auto-mode-alist '("\\.sass\\'" . ssass-mode)))

         ;; web-mode for all php files, as most WordPress
         ;; (eval . (add-to-list 'auto-mode-alist '("\\.php\\'" . web-mode)))
         ))

 ;; (js-mode . ((tab-width . 4)
 ;;             (eval . (setq indent-tabs-mode t))
 ;;             (js-indent-level . 4)
 ;;             ))

 ;; (html-mode . ((tab-width . 4)
 ;;               (eval . (setq indent-tabs-mode t))
 ;;               ))

 ;; (php-mode . ((tab-width . 4)
 ;;              (eval . (setq indent-tabs-mode t))
 ;;              ))

 (web-mode . ((tab-width . 4)
              (eval . (setq indent-tabs-mode t))
              (eval . (web-mode-use-tabs))
              ))

 ;; (ssass-mode . ((tab-width . 2)
 ;;                (eval . (setq indent-tabs-mode 0))
 ;;               ))

)
