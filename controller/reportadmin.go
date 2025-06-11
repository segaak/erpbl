package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

func ReportHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/report.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "report", map[string]interface{}{
			"CurrentPath": r.URL.Path,
		})
	}
}
