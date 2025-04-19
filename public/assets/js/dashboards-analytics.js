/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalRevenueChartEl = document.querySelector('#totalRevenueChart');
  const selectedYearSpan = document.getElementById('selectedYear');
  const yearDropdown = document.getElementById('yearDropdown');
  let totalRevenueChart = null;

  // Lấy năm hiện tại
  const currentYear = new Date().getFullYear();
  selectedYearSpan.textContent = currentYear;

  // Gọi lần đầu
  loadCustomerChart(currentYear);

  // Lắng nghe khi chọn năm từ dropdown
  yearDropdown.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function () {
      const selectedYear = this.getAttribute('data-year');
      selectedYearSpan.textContent = selectedYear;
      loadCustomerChart(selectedYear);
    });
  });

  function loadCustomerChart(year) {
    if (!totalRevenueChartEl) return;

    fetch(`/api/v1/customers/statistics/monthly?year=${year}`)
      .then(res => res.json())
      .then(data => {
        // Nếu đã có chart thì destroy trước khi render lại
        if (totalRevenueChart) {
          totalRevenueChart.destroy();
        }

        const totalRevenueChartOptions = {
          series: data.series,
          chart: {
            height: 300,
            stacked: true,
            type: 'bar',
            toolbar: { show: false }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '60%',
              borderRadius: 12,
              startingShape: 'rounded',
              endingShape: 'rounded'
            }
          },
          colors: [config.colors.primary, config.colors.info],
          dataLabels: { enabled: false },
          stroke: {
            curve: 'smooth',
            width: 6,
            lineCap: 'round',
            colors: [cardColor]
          },
          legend: {
            show: true,
            horizontalAlign: 'left',
            position: 'top',
            markers: {
              height: 8,
              width: 8,
              radius: 12,
              offsetX: -3
            },
            labels: { colors: axisColor },
            itemMargin: { horizontal: 10 }
          },
          grid: {
            borderColor: borderColor,
            padding: { top: 0, bottom: -8, left: 20, right: 20 }
          },
          xaxis: {
            categories: data.labels,
            labels: {
              style: { fontSize: '13px', colors: axisColor }
            },
            axisTicks: { show: false },
            axisBorder: { show: false }
          },
          yaxis: {
            labels: {
              style: { fontSize: '13px', colors: axisColor }
            }
          },
          responsive: [/* các breakpoint bạn đã định nghĩa như trên */],
          states: {
            hover: { filter: { type: 'none' } },
            active: { filter: { type: 'none' } }
          }
        };

        totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
        totalRevenueChart.render();
      })
      .catch(error => console.error('Error loading customer data:', error));
  }

  // Growth Chart - Radial Bar Chart
  // --------------------------------------------------------------------
    const currentMonth = new Date().getMonth() + 1; // +1 vì tháng trong JS bắt đầu từ 0

    // Hiển thị năm và tháng hiện tại trong các dropdown
    document.getElementById('selectedYear').textContent = currentYear;
    document.getElementById('selectedMonth').textContent = currentMonth;

    // Khi chọn năm mới từ dropdown
    document.querySelectorAll('#yearDropdown .dropdown-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const selectedYear = e.target.getAttribute('data-year');
            document.getElementById('selectedYear').textContent = selectedYear;
            updateGrowthChart(selectedYear, document.getElementById('selectedMonth').textContent);
        });
    });

    // Khi chọn tháng mới từ dropdown
    document.querySelectorAll('#monthDropdown .dropdown-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const selectedMonth = e.target.getAttribute('data-month');
            document.getElementById('selectedMonth').textContent = selectedMonth;
            updateGrowthChart(document.getElementById('selectedYear').textContent, selectedMonth);
        });
    });

    // Cập nhật biểu đồ với API
    function updateGrowthChart(year, month) {
        fetch(`/api/v1/customers/statistics/growth?year=${year}&month=${month}`)
            .then(res => res.json())
            .then(data => {
                const growth = data.growth;
                document.getElementById('growthPercentage').innerText = `${growth}% tăng trưởng công ty`;

                const growthChartOptions = {
                    series: [growth], // Cập nhật giá trị tỷ lệ tăng trưởng
                    labels: ['Growth'],
                    chart: {
                        height: 240,
                        type: 'radialBar'
                    },
                    plotOptions: {
                        radialBar: {
                            size: 150,
                            offsetY: 10,
                            startAngle: -150,
                            endAngle: 150,
                            hollow: {
                                size: '55%'
                            },
                            track: {
                                background: cardColor,
                                strokeWidth: '100%'
                            },
                            dataLabels: {
                                name: {
                                    offsetY: 15,
                                    color: headingColor,
                                    fontSize: '15px',
                                    fontWeight: '600',
                                    fontFamily: 'Public Sans'
                                },
                                value: {
                                    offsetY: -25,
                                    color: headingColor,
                                    fontSize: '22px',
                                    fontWeight: '500',
                                    fontFamily: 'Public Sans'
                                }
                            }
                        }
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            shadeIntensity: 0.5,
                            gradientToColors: [config.colors.primary],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 0.6,
                            stops: [30, 70, 100]
                        }
                    },
                    stroke: {
                        dashArray: 5
                    },
                    grid: {
                        padding: {
                            top: -35,
                            bottom: -10
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };

                const growthChartEl = document.querySelector('#growthChart');
                if (growthChartEl) {
                    const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
                    growthChart.render();
                }
            })
            .catch(error => {
                console.error('Error loading growth data:', error);
            });
    }

    // Khởi tạo biểu đồ với tháng và năm hiện tại khi tải trang
    updateGrowthChart(currentYear, currentMonth);

  // Income Chart - Area chart
  // --------------------------------------------------------------------
  const incomeChartEl = document.querySelector('#incomeChart'),
    incomeChartConfig = {
      series: [
        {
          data: [24, 21, 30, 22, 42, 26, 35, 29]
        }
      ],
      chart: {
        height: 215,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 6,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [
          {
            fillColor: config.colors.white,
            seriesIndex: 0,
            dataPointIndex: 7,
            strokeColor: config.colors.primary,
            strokeWidth: 2,
            size: 6,
            radius: 8
          }
        ],
        hover: {
          size: 7
        }
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.6,
          opacityFrom: 0.5,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        borderColor: borderColor,
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: -10,
          right: 8
        }
      },
      xaxis: {
        categories: ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          show: true,
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        },
        min: 10,
        max: 50,
        tickAmount: 4
      }
    };
  if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
    const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
    incomeChart.render();
  }

  // Expenses Mini Chart - Radial Chart
  // --------------------------------------------------------------------
  const weeklyExpensesEl = document.querySelector('#expensesOfWeek'),
    weeklyExpensesConfig = {
      series: [65],
      chart: {
        width: 60,
        height: 60,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          startAngle: 0,
          endAngle: 360,
          strokeWidth: '8',
          hollow: {
            margin: 2,
            size: '45%'
          },
          track: {
            strokeWidth: '50%',
            background: borderColor
          },
          dataLabels: {
            show: true,
            name: {
              show: false
            },
            value: {
              formatter: function (val) {
                return '$' + parseInt(val);
              },
              offsetY: 5,
              color: '#697a8d',
              fontSize: '13px',
              show: true
            }
          }
        }
      },
      fill: {
        type: 'solid',
        colors: config.colors.primary
      },
      stroke: {
        lineCap: 'round'
      },
      grid: {
        padding: {
          top: -10,
          bottom: -15,
          left: -10,
          right: -10
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof weeklyExpensesEl !== undefined && weeklyExpensesEl !== null) {
    const weeklyExpenses = new ApexCharts(weeklyExpensesEl, weeklyExpensesConfig);
    weeklyExpenses.render();
  }
})();
