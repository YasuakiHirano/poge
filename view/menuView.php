        <nav class="navbar navbar-dark bg-primary">
           <a class="navbar-brand" href="index.php">Poge</a>
           <ul class="nav navbar-nav">
             <li class="nav-item <?php echo $this->pageName == 'topCtl' ? 'active' : '' ?>">
                  <a class="nav-link" href="index.php">ホーム</a>
             </li>
             <li class="nav-item <?php echo $this->pageName == 'createBoardCtl' ? 'active' : '' ?>">
                   <a class="nav-link" href="index.php?page=createBoard">新規作成</a>
              </li>
              <!--
              <li class="nav-item">
                   <a class="nav-link" href="#">ヘルプ</a>
              </li>
              -->
           </ul>
        </nav>

