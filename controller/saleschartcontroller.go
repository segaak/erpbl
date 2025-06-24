// CONTROLLER: controller/dashboard.go
package controller

import (
	"database/sql"
	"encoding/json"
	"net/http"
	"strconv"
	"time"
)

type SalesData struct {
	Label string  `json:"label"`
	Value float64 `json:"value"`
}

func SalesChartHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		month := r.URL.Query().Get("month") // ex: "06" for June
		if month == "" {
			month = time.Now().Format("01")
		}

		year := time.Now().Year()
		rows, err := db.Query(`
			SELECT DAY(tanggal), SUM(total) 
			FROM pembayaran 
			WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ? 
			GROUP BY DAY(tanggal)
		`, month, year)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var results []SalesData
		for rows.Next() {
			var day int
			var total float64
			err := rows.Scan(&day, &total)
			if err != nil {
				continue
			}
			results = append(results, SalesData{
				Label: time.Date(year, time.Month(atoi(month)), day, 0, 0, 0, 0, time.UTC).Format("2 Jan"),
				Value: total,
			})
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(results)
	}
}

func atoi(s string) int {
	i, _ := strconv.Atoi(s)
	return i
}
