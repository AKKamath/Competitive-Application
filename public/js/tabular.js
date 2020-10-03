fetch('/api/contests.php')
  .then(res => res.json())
  .then(res => {
      let html = ``;
      res.forEach(contest => {
           html += `
              <tr>
                  <td><img src="${contest.img_site}" width="20" height="20"></td>
                  <td>${contest.name_site}</td>
                  <td><a href="${contest.site}">${contest.name_contest}</a></td>
                  <td>${contest.date_start}</td>
                  <td>${contest.date_end ? contest.date_end : 'unknown'}</td>
                  <td>${contest.description}</td>
              </tr>
          `;
      });

      document.querySelector('#tab-data').innerHTML = html;
  })
  .catch(error => {
    // handle the error
    console.log(error);
});