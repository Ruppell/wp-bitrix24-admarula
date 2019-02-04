(
 (nil . ((tab-width . 4)
         (js-indent-level . 4)

         ;; web-mode for all php files, as most WordPress
         ;; (eval . (add-to-list 'auto-mode-alist '("\\.php\\'" . web-mode)))
         ))

 (web-mode . ((tab-width . 4)
              (eval . (setq indent-tabs-mode t))
              (eval . (web-mode-use-tabs))
              ))
 )
